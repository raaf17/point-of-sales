<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenjualanController extends Controller
{
    public function index()
    {
        $pendapatan = DB::table('penjualan')
            ->selectRaw("SUM(bayar) as total_pendapatan")
            ->get()
            ->pluck('total_pendapatan')
            ->first();
            
        return view('penjualan.index', compact('pendapatan'), [
            'title' => 'Laporan Penjualan'
        ]);
    }

    public function data(Request $request)
    {
        $penjualan = Penjualan::with('member')->orderBy('id_penjualan', 'desc');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $penjualan->whereBetween('created_at', [$request->tanggal_awal . ' 00:00:00', $request->tanggal_akhir . ' 23:59:59']);
        }

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp. ' . format_uang($penjualan->total_harga);
            })
            ->addColumn('bayar', function ($penjualan) {
                return 'Rp. ' . format_uang($penjualan->bayar);
            })
            ->addColumn('tanggal', function ($penjualan) {
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->diskon;
            })
            ->editColumn('kasir', function ($penjualan) {
                return $penjualan->user->name ?? '';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`' . route('penjualan.show', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`' . route('penjualan.destroy', $penjualan->id_penjualan) . '`)" class="btn btn-xs btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->editColumn('nama', function ($penjualan) {
                if (empty($penjualan->id_member)) {
                    return 'Umum';
                }

                return Member::where('id_member', $penjualan->id_member)->value('nama') ?? 'Umum';
            })
            ->editColumn('tipe_member', function ($penjualan) {
                if (empty($penjualan->id_member)) {
                    return '-';
                }

                return Member::where('id_member', $penjualan->id_member)->value('tipe_member') ?? '-';
            })
            ->editColumn('poin', function ($penjualan) {
                if (empty($penjualan->id_member)) {
                    return '0';
                }

                return Member::where('id_member', $penjualan->id_member)->value('poin') ?? '-';
            })
            ->rawColumns(['aksi', 'nama', 'tipe_member', 'poin'])
            ->make(true);
    }

    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->id_member = null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);
        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $penjualan->id_member = $request->id_member;
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total;
        $penjualan->diskon = $request->diskon;
        $penjualan->bayar = $request->bayar;
        $penjualan->diterima = $request->diterima;
        $penjualan->update();
        $member = Member::find($request->id_member);
        $member->poin += $request->poin;
        $member->update();

        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $item->diskon = $request->diskon;
            $item->update();

            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }

        return redirect()->route('transaksi.selesai');
    }

    public function show($id)
    {
        $detail = PenjualanDetail::with('produk')->where('id_penjualan', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">' . $detail->produk->kode_produk . '</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. ' . format_uang($detail->harga_jual);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $detail    = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }

            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }

    public function selesai()
    {
        $setting = Setting::first();

        return view('penjualan.selesai', compact('setting'), [
            'title' => 'Penjualan'
        ]);
    }

    public function notaKecil()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        return view('penjualan.nota_kecil', compact('setting', 'penjualan', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        $pdf = PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0, 0, 609, 440, 'potrait');
        return $pdf->stream('Transaksi-' . date('Y-m-d-his') . '.pdf');
    }

    public function export()
    {
        $penjualan = Penjualan::with('member')->orderBy('created_at', 'DESC')->get();

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $date = date('d-m-Y - H:i');
        $downloder = 'Pengunduh : ' . Auth::user()->name;
        $today = 'Tanggal : ' . $date;
        $website_name = 'Kasirku';

        $styleArrayCenterBold = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $styleArrayCenterBold20px = [
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $styleArraycenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $activeWorksheet->mergeCells('A1:I1');
        $activeWorksheet->setCellValue('A1', 'DATA PENJUALAN');
        $activeWorksheet->getStyle('A1')->applyFromArray($styleArrayCenterBold20px);

        $activeWorksheet->mergeCells('A2:I2');
        $activeWorksheet->setCellValue('A2', $website_name);
        $activeWorksheet->getStyle('A2')->applyFromArray($styleArraycenter);

        $activeWorksheet->mergeCells('A3:I3');
        $activeWorksheet->setCellValue('A3', $today);
        $activeWorksheet->getStyle('A3')->applyFromArray($styleArraycenter);

        $activeWorksheet->mergeCells('A4:I4');
        $activeWorksheet->setCellValue('A4', $downloder);
        $activeWorksheet->getStyle('A4')->applyFromArray($styleArraycenter);

        $activeWorksheet->getStyle('A1:I1')->getFont()->setName('Consolas');
        $activeWorksheet->getStyle('A2:I2')->getFont()->setName('Consolas')->setSize(10);
        $activeWorksheet->getStyle('A3:I3')->getFont()->setName('Consolas')->setSize(10);
        $activeWorksheet->getStyle('A4:I4')->getFont()->setName('Consolas')->setSize(10);

        foreach (range('A', 'I') as $columnID) {
            $activeWorksheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '5a8ed1',
                ],
                'endColor' => [
                    'argb' => '5a8ed1',
                ],
            ],
        ];

        $activeWorksheet->getStyle('A6:I6')->applyFromArray($styleArray);
        $activeWorksheet->setCellValue('A6', 'NO');
        $activeWorksheet->setCellValue('B6', 'KASIR');
        $activeWorksheet->setCellValue('C6', 'WAKTU & TANGGAL TRANSAKSI');
        $activeWorksheet->setCellValue('D6', 'NAMA PELANGGAN');
        $activeWorksheet->setCellValue('E6', 'TIPE PELANGGAN');
        $activeWorksheet->setCellValue('F6', 'TOTAL PEMBELANJAAN');
        $activeWorksheet->setCellValue('G6', 'DISKON (Rp.)');
        $activeWorksheet->setCellValue('H6', 'POIN DIGUNAKAN');
        $activeWorksheet->setCellValue('I6', 'TOTAL AKHIR');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $column = 7;
        $no = 1;
        foreach ($penjualan as $key => $value) {
            $activeWorksheet->setCellValue('A' . $column, $no);
            $activeWorksheet->setCellValue('B' . $column, Auth::user()->name);
            $activeWorksheet->setCellValue('C' . $column, tanggal_indonesia($value->created_at));
            if (empty($value->id_member)) {
                $nama_pelanggan = 'Umum';
            } else {
                $nama_pelanggan = Member::where('id_member', $value->id_member)->value('nama') ?? 'Umum';
            }
            $activeWorksheet->setCellValue('D' . $column, $nama_pelanggan);
            if (empty($value->id_member)) {
                $tipe_member = '-';
            } else {
                $tipe_member = Member::where('id_member', $value->id_member)->value('tipe_member') ?? '-';
            }
            $activeWorksheet->setCellValue('E' . $column, $tipe_member);
            $activeWorksheet->setCellValue('F' . $column, 'Rp. ' . format_uang($value->total_harga));
            $activeWorksheet->setCellValue('G' . $column, $value->diskon . '%');
            if (empty($value->id_member)) {
                $poin = '-';
            } else {
                $poin = Member::where('id_member', $value->id_member)->value('poin') ?? '-';
            }
            $activeWorksheet->setCellValue('H' . $column, $poin);
            $activeWorksheet->setCellValue('I' . $column, 'Rp. ' . format_uang($value->bayar));

            $column++;
            $no++;
        }

        $dirPath = 'report/export/';
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        $filename = 'data-penjualan_' . date('d-m-y-H-i-s') . '.xlsx';
        $filePath = $dirPath . $filename;

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}

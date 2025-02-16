<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanStokController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');

        return view('laporan_stok.index', compact('kategori'), [
            'title' => 'Laporan Stok Barang'
        ]);
    }

    public function data()
    {
        $produk = Produk::select('kode_produk', 'nama_produk', 'stok', 'tgl_kadaluarsa', 'created_at')->orderBy('kode_produk', 'asc')->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->editColumn('tgl_kadaluarsa', function ($produk) {
                $html = "";
                $now = date('Y-m-d');
                $exp_date = $produk->tgl_kadaluarsa;
                $diff_days = (strtotime($exp_date) - strtotime($now)) / (60 * 60 * 24);

                if ($now == $exp_date || $now > $exp_date) {
                    $html = '<span class="badge bg-danger">Produk Kadaluarsa</span>';
                } elseif ($diff_days > 0 && $diff_days <= 7) {
                    $html = $exp_date . ' (Hampir Kadaluarsa)';
                } else {
                    $html = $exp_date;
                }

                return $html;
            })
            ->editColumn('created_at', function ($produk) {
                return Carbon::parse($produk->created_at)->format('M j, Y');
            })
            ->rawColumns(['created_at', 'tgl_kadaluarsa'])
            ->make(true);
    }

    public function export()
    {
        $produk = Produk::select('kode_produk', 'nama_produk', 'stok', 'tgl_kadaluarsa', 'created_at')->orderBy('created_at', 'asc')->get();

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

        $activeWorksheet->mergeCells('A1:F1');
        $activeWorksheet->setCellValue('A1', 'DATA PENJUALAN');
        $activeWorksheet->getStyle('A1')->applyFromArray($styleArrayCenterBold20px);

        $activeWorksheet->mergeCells('A2:F2');
        $activeWorksheet->setCellValue('A2', $website_name);
        $activeWorksheet->getStyle('A2')->applyFromArray($styleArraycenter);

        $activeWorksheet->mergeCells('A3:F3');
        $activeWorksheet->setCellValue('A3', $today);
        $activeWorksheet->getStyle('A3')->applyFromArray($styleArraycenter);

        $activeWorksheet->mergeCells('A4:F4');
        $activeWorksheet->setCellValue('A4', $downloder);
        $activeWorksheet->getStyle('A4')->applyFromArray($styleArraycenter);

        $activeWorksheet->getStyle('A1:F1')->getFont()->setName('Consolas');
        $activeWorksheet->getStyle('A2:F2')->getFont()->setName('Consolas')->setSize(10);
        $activeWorksheet->getStyle('A3:F3')->getFont()->setName('Consolas')->setSize(10);
        $activeWorksheet->getStyle('A4:F4')->getFont()->setName('Consolas')->setSize(10);

        foreach (range('A', 'F') as $columnID) {
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

        $activeWorksheet->getStyle('A6:F6')->applyFromArray($styleArray);
        $activeWorksheet->setCellValue('A6', 'NO');
        $activeWorksheet->setCellValue('B6', 'KODE PRODUK');
        $activeWorksheet->setCellValue('C6', 'NAMA PRODUK');
        $activeWorksheet->setCellValue('D6', 'TANGGAL PEMBELIAN');
        $activeWorksheet->setCellValue('E6', 'TANGGAL KADALUARSA');
        $activeWorksheet->setCellValue('F6', 'SISA STOK');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $column = 7;
        $no = 1;
        foreach ($produk as $key => $value) {
            $activeWorksheet->setCellValue('A' . $column, $no);
            $activeWorksheet->setCellValue('B' . $column, $value->kode_produk);
            $activeWorksheet->setCellValue('C' . $column, $value->nama_produk);
            $activeWorksheet->setCellValue('D' . $column, tanggal_indonesia($value->created_at));
            $activeWorksheet->setCellValue('E' . $column, tanggal_indonesia($value->tgl_kadaluarsa));
            $activeWorksheet->setCellValue('F' . $column, $value->stok);

            $column++;
            $no++;
        }

        $dirPath = 'report/export/';
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        $filename = 'data-stokbarang_' . date('d-m-y-H-i-s') . '.xlsx';
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

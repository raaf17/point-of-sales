<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanStokController extends Controller
{
    public function index()
    {
        return view('laporan_stok.index', [
            'title' => 'Laporan Stok Barang'
        ]);
    }

    public function data()
    {
        $produk = Produk::with('stok')->orderBy('kode_produk', 'asc')->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" class="btn btn-xs btn-info btn-flat btn-sm view-btn" data-id="' . $produk->id_produk . '">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                ';
            })
            ->addColumn('stok', function ($produk) {
                return $produk->stok->where('tgl_kadaluarsa', '>=', now())->sum('stok');
            })
            ->rawColumns(['stok', 'aksi'])
            ->make(true);
    }

    public function view($id)
    {
        $produk = Produk::with(['stok' => function ($query) {
            $query->orderBy('tgl_kadaluarsa', 'asc');
        }])->find($id);

        if (!$produk) {
            return response()->json(['error' => 'Produk tidak ditemukan!'], 404);
        }

        return view('laporan_stok.view', compact('produk'));
    }

    public function export()
    {
        $produk = Produk::with(['stok' => function ($query) {
            $query->orderBy('tgl_pembelian', 'asc')->orderBy('tgl_kadaluarsa', 'asc');
        }])->orderBy('kode_produk', 'asc')->get();

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $date = date('d-m-Y - H:i');
        $downloder = 'Pengunduh : ' . Auth::user()->name;
        $today = 'Tanggal : ' . $date;
        $website_name = 'Kasirku';

        // Style
        $styleArrayCenterBold20px = [
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
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
        $styleArrayBorder = [
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ];

        $styleArraycenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $activeWorksheet->mergeCells('A1:F1');
        $activeWorksheet->setCellValue('A1', 'DATA STOK');
        $activeWorksheet->getStyle('A1')->applyFromArray($styleArrayCenterBold20px);

        $activeWorksheet->mergeCells('A2:F2');
        $activeWorksheet->setCellValue('A2', $website_name);
        $activeWorksheet->mergeCells('A3:F3');
        $activeWorksheet->setCellValue('A3', $today);
        $activeWorksheet->mergeCells('A4:F4');
        $activeWorksheet->setCellValue('A4', $downloder);
        $activeWorksheet->getStyle('A2:A4')->applyFromArray($styleArraycenter);

        $activeWorksheet->getStyle('A1:F1')->getFont()->setName('Consolas');
        $activeWorksheet->getStyle('A2:F2')->getFont()->setName('Consolas')->setSize(10);
        $activeWorksheet->getStyle('A3:F3')->getFont()->setName('Consolas')->setSize(10);
        $activeWorksheet->getStyle('A4:F4')->getFont()->setName('Consolas')->setSize(10);

        $activeWorksheet->getStyle('A6:F6')->applyFromArray($styleArray);
        $activeWorksheet->setCellValue('A6', 'NO');
        $activeWorksheet->setCellValue('B6', 'KODE PRODUK');
        $activeWorksheet->setCellValue('C6', 'NAMA PRODUK');
        $activeWorksheet->setCellValue('D6', 'TANGGAL PEMBELIAN');
        $activeWorksheet->setCellValue('E6', 'TGL KADALUARSA');
        $activeWorksheet->setCellValue('F6', 'JUMLAH STOK');

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $styleArrayTableHeader = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '5A8ED1'],
            ],
        ];

        $row = 7;
        $no = 1;
        $totalSemuaStok = 0;

        foreach ($produk as $item) {
            $stokByTanggal = $item->stok->groupBy('tgl_pembelian');

            foreach ($stokByTanggal as $tgl_pembelian => $stokList) {
                $totalStokPembelian = $stokList->sum('stok');

                foreach ($stokList as $stok) {
                    $activeWorksheet->setCellValue('A' . $row, $no);
                    $activeWorksheet->setCellValue('B' . $row, $item->kode_produk);
                    $activeWorksheet->setCellValue('C' . $row, $item->nama_produk);
                    $activeWorksheet->setCellValue('D' . $row, $stok->tgl_pembelian);
                    $activeWorksheet->setCellValue('E' . $row, $stok->tgl_kadaluarsa);
                    $activeWorksheet->setCellValue('F' . $row, $stok->stok);

                    $row++;
                    $no++;
                }
            }

            $totalSemuaStok += $stokByTanggal->flatten()->sum('stok');
        }

        $activeWorksheet->mergeCells("A$row:E$row");
        $activeWorksheet->setCellValue("A$row", "TOTAL SEMUA STOK");
        $activeWorksheet->getStyle("A$row")->applyFromArray($styleArrayTableHeader);
        $activeWorksheet->setCellValue("F$row", $totalSemuaStok);
        $activeWorksheet->getStyle("A$row:F$row")->applyFromArray($styleArrayBorder);

        foreach (range('A', 'F') as $columnID) {
            $activeWorksheet->getColumnDimension($columnID)->setAutoSize(true);
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

    public function exportPDF()
    {
        $produk = Produk::with(['stok' => function ($query) {
            $query->orderBy('tgl_pembelian', 'asc')->orderBy('tgl_kadaluarsa', 'asc');
        }])->orderBy('kode_produk', 'asc')->get();

        $date = date('d-m-Y - H:i');
        $downloder = 'Pengunduh : ' . Auth::user()->name;
        $today = 'Tanggal : ' . $date;
        $website_name = 'Kasirku';

        $pdf = Pdf::loadHTML($this->generateHTML($produk, $website_name, $today, $downloder));
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $filename = 'data-stokbarang_' . date('d-m-y-H-i-s') . '.pdf';
        return $pdf->stream($filename, ['Attachment' => 0]);
    }

    private function generateHTML($produk, $website_name, $today, $downloder)
    {
        $html = "
    <h1 style='text-align:center; font-family: Consolas; font-size: 20px;'>DATA PENJUALAN</h1>
    <h3 style='text-align:center; font-family: Consolas; font-size: 14px;'>{$website_name}</h3>
    <p style='font-family: Consolas;'>{$today}</p>
    <p style='font-family: Consolas;'>{$downloder}</p>
    <table style='width:100%; border: 1px solid black; border-collapse: collapse; font-family: Consolas;'>
        <thead>
            <tr style='background-color: #5A8ED1; color: white;'>
                <th style='padding: 8px; text-align:center;'>NO</th>
                <th style='padding: 8px; text-align:center;'>KODE PRODUK</th>
                <th style='padding: 8px; text-align:center;'>NAMA PRODUK</th>
                <th style='padding: 8px; text-align:center;'>TANGGAL PEMBELIAN</th>
                <th style='padding: 8px; text-align:center;'>TGL KADALUARSA</th>
                <th style='padding: 8px; text-align:center;'>JUMLAH STOK</th>
            </tr>
        </thead>
        <tbody>";

        $no = 1;
        $totalSemuaStok = 0;

        foreach ($produk as $item) {
            $stokByTanggal = $item->stok->groupBy('tgl_pembelian');

            foreach ($stokByTanggal as $tgl_pembelian => $stokList) {
                foreach ($stokList as $stok) {
                    $html .= "
                <tr>
                    <td style='padding: 8px; text-align:center;'>{$no}</td>
                    <td style='padding: 8px; text-align:center;'>{$item->kode_produk}</td>
                    <td style='padding: 8px; text-align:center;'>{$item->nama_produk}</td>
                    <td style='padding: 8px; text-align:center;'>{$stok->tgl_pembelian}</td>
                    <td style='padding: 8px; text-align:center;'>{$stok->tgl_kadaluarsa}</td>
                    <td style='padding: 8px; text-align:center;'>{$stok->stok}</td>
                </tr>";

                    $no++;
                }
            }

            $totalSemuaStok += $stokByTanggal->flatten()->sum('stok');
        }

        $html .= "
        </tbody>
        <tfoot>
            <tr style='font-weight: bold;'>
                <td colspan='5' style='text-align:right; padding: 8px;'>TOTAL SEMUA STOK</td>
                <td style='padding: 8px; text-align:center;'>{$totalSemuaStok}</td>
            </tr>
        </tfoot>
    </table>";

        return $html;
    }
}

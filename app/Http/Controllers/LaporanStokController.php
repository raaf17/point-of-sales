<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Carbon\Carbon;
use PDF;

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
}

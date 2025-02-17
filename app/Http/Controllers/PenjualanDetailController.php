<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $member = Member::orderBy('nama')->get();
        $diskons = Diskon::orderBy('kode_diskon')->get();

        if ($id_penjualan = session('id_penjualan')) {
            $penjualan = Penjualan::find($id_penjualan);
            $memberSelected = $penjualan->member->diskon ?? new Member();

            return view('penjualan_detail.index', compact('produk', 'member', 'id_penjualan', 'penjualan', 'memberSelected', 'diskons'), [
                'title' => 'Transaksi Baru'
            ]);
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', $id)
            ->get();

        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="label label-success">' . $item->produk['kode_produk'] . '</span';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual']  = 'Rp. ' . format_uang($item->produk['harga_beli'] + ($item->produk['harga_beli'] * 30 / 100));
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id_penjualan_detail . '" value="' . $item->jumlah . '">';
            $row['diskon']      = $item->diskon . '%';
            $row['subtotal']    = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`' . route('transaksi.destroy', $item->id_penjualan_detail) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $harga_jual  = $item->produk['harga_beli'] + ($item->produk['harga_beli'] * 30 / 100);

            $total += $harga_jual * $item->jumlah - (($item->diskon * $item->jumlah) / 100 * $harga_jual);;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'kode_produk' => '
                <div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>',
            'nama_produk' => '',
            'harga_jual'  => '',
            'jumlah'      => '',
            'diskon'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (!$produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_jual = $produk->harga_beli + ($produk->harga_beli * 30 / 100);
        $detail->jumlah = 1;
        $detail->diskon = $produk->diskon;
        $harga_jual = $produk->harga_beli + ($produk->harga_beli * 30 / 100);
        $detail->subtotal = $harga_jual - ($produk->diskon / 100 * $harga_jual);
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $harga_jual = ($detail->harga_beli + ($detail->harga_beli * 30 / 100));
        $detail->subtotal = $harga_jual * $request->jumlah - (($detail->diskon * $request->jumlah) / 100 * $harga_jual);
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($total = 0, $diterima = 0)
    {
        $subtotal = $total;
        $pajak = 12 / 100 * $subtotal;
        $bayar = $subtotal + $pajak;
        $data    = [
            'totalrp' => $total,
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'kembali' => ($diterima != 0) ? $diterima - $bayar : 0,
        ];

        return response()->json($data);
    }
}

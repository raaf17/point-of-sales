<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Stok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PDF;

class ProdukController extends Controller
{
    public function index()
    {
        return view('produk.index', [
            'title' => 'Produk'
        ]);
    }

    public function data()
    {
        $produk = Produk::with('stok')
            ->leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            // ->leftJoin('stok', 'stok.id_produk', 'produk.id_produk')
            ->select('produk.*', 'nama_kategori', 'warna')
            ->orderBy('kode_produk', 'DESC')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual_1', function ($produk) {
                return format_uang($produk->harga_beli + ($produk->harga_beli * 10 / 100));
            })
            ->addColumn('harga_jual_2', function ($produk) {
                return format_uang($produk->harga_beli + ($produk->harga_beli * 20 / 100));
            })
            ->addColumn('harga_jual_3', function ($produk) {
                return format_uang($produk->harga_beli + ($produk->harga_beli * 30 / 100));
            })
            ->addColumn('stok', function ($produk) {
                return $produk->stok->where('tgl_kadaluarsa', '>=', now())->sum('stok');
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="addQty(' . $produk->id_produk . ')" class="btn btn-xs btn-primary btn-flat btn-sm add-stok-btn"><i class="fa fa-plus"></i></button>
                    <button type="button" onclick="view(' . $produk->id_produk . ')" class="btn btn-xs btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></button>
                    <button type="button" onclick="edit(' . $produk->id_produk . ')" class="btn btn-xs btn-warning btn-flat btn-sm"><i class="fa fa-pen"></i></button>
                    <button type="button" onclick="destroy(' . $produk->id_produk . ')" class="btn btn-xs btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->editColumn('nama_kategori', function ($produk) {
                return '<span class="badge bg-' . $produk->warna . '">' . $produk->nama_kategori . '</span>';
            })
            ->rawColumns(['aksi', 'nama_kategori'])
            ->make(true);
    }

    public function addQty($id)
    {
        $id = $id;
        return view('produk.addqty', compact('id'));
    }

    public function storeQty(Request $request, $id)
    {
        $post = request()->all();
        $validator = Validator::make($post, [
            'stok' => 'required',
        ], [
            'required' => ':attribute is required.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'An input error occurred.',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = [
            'id_produk' => $id,
            'stok' => $request->stok,
            'tgl_pembelian' => $request->tgl_pembelian,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
        ];
        $query = Stok::create($data);

        if ($query) {
            return response()->json([
                'success' => true,
                'message' => 'Data stok berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data stok gagal diupdate'
            ]);
        }
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $post = request()->all();
        $validator = Validator::make($post, [
            'nama_produk' => 'required',
        ], [
            'required' => ':attribute is required.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'An input error occurred.',
                'errors' => $validator->errors()
            ], 400);
        }

        $produk = Produk::latest()->first() ?? new Produk();
        $data = [
            'kode_produk' => 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6),
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'diskon' => $request->diskon,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            'stok' => $request->stok,
            'minimal_stok' => $request->minimal_stok,
        ];
        $query = Produk::create($data);

        if ($query) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }
    }

    public function view($id)
    {
        $produk = Produk::select('produk.*', 'kategori.*')
            ->join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
            ->where('produk.id_produk', $id)
            ->first();

        $kategori = '<span class="badge bg-light-' . $produk->warna . '">' . $produk->nama_kategori . '</span>';
        $harga_jual_1 = format_uang($produk->harga_beli + ($produk->harga_beli * 10 / 100));
        $harga_jual_2 = format_uang($produk->harga_beli + ($produk->harga_beli * 20 / 100));
        $harga_jual_3 = format_uang($produk->harga_beli + ($produk->harga_beli * 30 / 100));

        return view('produk.view', compact('produk', 'kategori', 'harga_jual_1', 'harga_jual_2', 'harga_jual_3'));
    }

    public function edit($id)
    {
        $produk = Produk::find($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $post = request()->all();
        $produk = Produk::find($id);
        $validator = Validator::make($post, [
            'nama_produk' => 'required',
        ], [
            'required' => ':attribute is required.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'An input error occurred.',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = [
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'diskon' => $request->diskon,
            'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            'stok' => $request->stok,
            'minimal_stok' => $request->minimal_stok,
        ];
        $query = $produk->update($data);

        if ($query) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }
    }

    public function delete($id)
    {
        $produk = Produk::find($id);
        if ($produk) {
            if ($produk->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal dihapus'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}

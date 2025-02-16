<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index', [
            'title' => 'Kategori'
        ]);
    }

    public function data()
    {
        $kategori = Kategori::orderBy('kode_kategori', 'ASC')->get();

        return datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="view(' . $kategori->id_kategori . ')" class="btn btn-xs btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></button>
                    <button type="button" onclick="edit(' . $kategori->id_kategori . ')" class="btn btn-xs btn-warning btn-flat btn-sm"><i class="fa fa-pen"></i></button>
                    <button type="button" onclick="destroy(' . $kategori->id_kategori . ')" class="btn btn-xs btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $post = request()->all();
        $validator = Validator::make($post, [
            'nama_kategori' => 'required',
        ], [
            'required' => ':attribute is required.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'An input error occurred.',
                'errors' => $validator->errors()
            ], 400);
        }

        $kategori = Kategori::latest()->first() ?? new Kategori();
        $data = [
            'kode_kategori' => 'KTGR' . tambah_nol_didepan((int)$kategori->id_kategori + 1, 3),
            'nama_kategori' => $request->nama_kategori,
            'warna' => $request->warna,
        ];
        $query = Kategori::create($data);

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
        $kategori = Kategori::find($id);
        return view('kategori.view', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $post = request()->all();
        $kategori = Kategori::find($id);
        $validator = Validator::make($post, [
            'nama_kategori' => 'required',
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
            'nama_kategori' => $request->nama_kategori,
            'warna' => $request->warna,
        ];
        $query = $kategori->update($data);

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
        $kategori = Kategori::find($id);
        if ($kategori) {
            if ($kategori->delete()) {
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
}

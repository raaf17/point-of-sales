<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiskonController extends Controller
{
    public function index()
    {
        return view('diskon.index', [
            'title' => 'Diskon'
        ]);
    }

    public function data()
    {
        $diskon = Diskon::orderBy('kode_diskon', 'ASC')->get();

        return datatables()
            ->of($diskon)
            ->addIndexColumn()
            ->addColumn('aksi', function ($diskon) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="view(' . $diskon->id_diskon . ')" class="btn btn-xs btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></button>
                    <button type="button" onclick="edit(' . $diskon->id_diskon . ')" class="btn btn-xs btn-warning btn-flat btn-sm"><i class="fa fa-pen"></i></button>
                    <button type="button" onclick="destroy(' . $diskon->id_diskon . ')" class="btn btn-xs btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->addColumn('waktu', function ($diskon) {
                return Carbon::parse($diskon->tgl_mulai)->format('M j, Y') . ' sampai ' . Carbon::parse($diskon->tgl_berakhir)->format('M j, Y');
            })
            ->addColumn('diskon', function ($diskon) {
                return $diskon->diskon . '%';
            })
            ->rawColumns(['aksi', 'waktu'])
            ->make(true);
    }

    public function create()
    {
        return view('diskon.create');
    }

    public function store(Request $request)
    {
        $post = request()->all();
        $validator = Validator::make($post, [
            'nama_diskon' => 'required',
            'min_diskon' => 'required|numeric|lt:diskon',
            'max_diskon' => 'required|numeric|gt:diskon',
            'diskon' => 'required|numeric|max:100',
            'tgl_mulai' => 'required|date|before_or_equal:tgl_berakhir',
            'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
        ], [
            'required' => ':attribute harus diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => 'Diskon tidak boleh lebih dari 100%.',
            'lt' => 'Minimal diskon harus lebih kecil dari nilai diskon.',
            'gt' => 'Maksimal diskon harus lebih besar dari nilai diskon.',
            'before_or_equal' => 'Tanggal mulai tidak boleh lebih dari tanggal berakhir.',
            'after_or_equal' => 'Tanggal berakhir tidak boleh lebih kecil dari tanggal mulai.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'An input error occurred.',
                'errors' => $validator->errors()
            ], 400);
        }

        $diskon = Diskon::latest()->first() ?? new Diskon();
        $data = [
            'kode_diskon' => 'DSKN' . tambah_nol_didepan((int)$diskon->id_diskon + 1, 3),
            'nama_diskon' => $request->nama_diskon,
            'min_diskon' => $request->min_diskon,
            'max_diskon' => $request->max_diskon,
            'diskon' => $request->diskon,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_berakhir' => $request->tgl_berakhir
        ];
        $query = Diskon::create($data);

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
        $diskon = Diskon::find($id);
        return view('diskon.view', compact('diskon'));
    }

    public function edit($id)
    {
        $diskon = Diskon::find($id);
        return view('diskon.edit', compact('diskon'));
    }

    public function update(Request $request, $id)
    {
        $post = request()->all();
        $diskon = Diskon::find($id);
        $validator = Validator::make($post, [
            'nama_diskon' => 'required',
            'min_diskon' => 'required|numeric|lt:diskon',
            'max_diskon' => 'required|numeric|gt:diskon',
            'diskon' => 'required|numeric|max:100',
            'tgl_mulai' => 'required|date|before_or_equal:tgl_berakhir',
            'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
        ], [
            'required' => ':attribute harus diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => 'Diskon tidak boleh lebih dari 100%.',
            'lt' => 'Minimal diskon harus lebih kecil dari nilai diskon.',
            'gt' => 'Maksimal diskon harus lebih besar dari nilai diskon.',
            'before_or_equal' => 'Tanggal mulai tidak boleh lebih dari tanggal berakhir.',
            'after_or_equal' => 'Tanggal berakhir tidak boleh lebih kecil dari tanggal mulai.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'An input error occurred.',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = [
            'nama_diskon' => $request->nama_diskon,
            'min_diskon' => $request->min_diskon,
            'max_diskon' => $request->max_diskon,
            'diskon' => $request->diskon,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_berakhir' => $request->tgl_berakhir
        ];
        $query = $diskon->update($data);

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
        $diskon = Diskon::find($id);
        if ($diskon) {
            if ($diskon->delete()) {
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

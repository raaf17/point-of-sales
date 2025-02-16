<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.index', [
            'title' => 'Members'
        ]);
    }

    public function data()
    {
        $member = Member::orderBy('kode_member')->get();

        return datatables()
            ->of($member)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_member[]" value="' . $produk->id_member . '">
                ';
            })
            ->addColumn('kode_member', function ($member) {
                return '<span class="label label-success">' . $member->kode_member . '<span>';
            })
            ->addColumn('aksi', function ($member) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="view(' . $member->id_member . ')" class="btn btn-xs btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></button>
                    <button type="button" onclick="edit(' . $member->id_member . ')" class="btn btn-xs btn-warning btn-flat btn-sm"><i class="fa fa-pen"></i></button>
                    <button type="button" onclick="destroy(' . $member->id_member . ')" class="btn btn-xs btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'select_all', 'kode_member'])
            ->make(true);
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $post = request()->all();
        $validator = Validator::make($post, [
            'nama' => 'required',
        ], [
            'required' => ':attribute is required.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'  => 'An input error occurred.',
                'errors' => $validator->errors()
            ], 400);
        }

        $member = Member::latest()->first() ?? new Member();
        $data = [
            'kode_member' => tambah_nol_didepan((int)$member->id_member + 1, 3),
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tipe_member' => $request->tipe_member,
        ];
        $query = Member::create($data);

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
        $member = Member::find($id);
        return view('member.view', compact('member'));
    }

    public function edit($id)
    {
        $member = Member::find($id);
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $post = request()->all();
        $member = Member::find($id);
        $validator = Validator::make($post, [
            'nama' => 'required',
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
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tipe_member' => $request->tipe_member,
        ];
        $query = $member->update($data);

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
        $member = Member::find($id);
        if ($member) {
            if ($member->delete()) {
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

    public function cetakMember(Request $request)
    {
        $datamember = collect(array());
        foreach ($request->id_member as $id) {
            $member = Member::find($id);
            $datamember[] = $member;
        }

        $datamember = $datamember->chunk(2);
        $setting    = Setting::first();

        $no  = 1;
        $pdf = PDF::loadView('member.cetak', compact('datamember', 'no', 'setting'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');
        return $pdf->stream('member.pdf');
    }
}

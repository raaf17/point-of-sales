<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'title' => 'Users'
        ]);
    }

    public function data()
    {
        $user = User::isNotAdmin()->orderBy('id', 'desc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="view(' . $user->id . ')" class="btn btn-xs btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></button>
                    <button type="button" onclick="edit(' . $user->id . ')" class="btn btn-xs btn-warning btn-flat btn-sm"><i class="fa fa-pen"></i></button>
                    <button type="button" onclick="destroy(' . $user->id . ')" class="btn btn-xs btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $post = request()->all();
        $validator = Validator::make($post, [
            'nama_user' => 'required',
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 2,
            'foto' => '/img/user.jpg',
        ];
        $query = User::create($data);

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
        $user = User::find($id);
        return view('user.view', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $post = request()->all();
        $user = User::find($id);
        $validator = Validator::make($post, [
            'nama_user' => 'required',
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
            'nama_user' => $request->nama_user,
            'warna' => $request->warna,
        ];
        if ($request->has('password') && $request->password != "") {
            $data['password'] = bcrypt($request->password);
        }
        $query = $user->update($data);

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
        $user = User::find($id);
        if ($user) {
            if ($user->delete()) {
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

    public function profil()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'), [
            'title' => 'Profil'
        ]);
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $user->name = $request->name;
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "/img/$nama";
        }

        $user->update();

        return response()->json($user, 200);
    }
}

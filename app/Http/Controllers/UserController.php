<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{

    public function getUsers()
    {
        $users = User::select('id', 'nama_pengurus')->get();
        return response()->json($users);
    }

    public function index()
    {
        $data = user::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<a class="btn btn-primary btn-sm mx-1 btnEdit" href="#" data-id="' . $row->id . '">Edit</a>';
                $btn .= '<a class="btn btn-danger btn-sm mx-1 btnDel" href="#" data-id="' . $row->id . '">Hapus</a>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama_pengurus' => 'required|string|max:255',
            'nik' => 'required|string|min:16|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'nama_pengurus' => $request->nama_pengurus,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => 'User created successfully.']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_pengurus' => 'required|string|max:255',
            'nik' => 'required|string|min:16|max:255|unique:users,nik,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);


        $user->update([
            'nama_pengurus' => $request->nama,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json(['success' => 'User updated successfully.']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }


    public function getData()
    {
        $users = User::all();
        return response()->json($users);
    }
}

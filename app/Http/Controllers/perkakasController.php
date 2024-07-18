<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkakas;
use Yajra\DataTables\Facades\DataTables;

class PerkakasController extends Controller
{
    public function index()
    {


        $data = Perkakas::latest();
        return DataTables::of($data)
            ->rawColumns(['aksi'])
            ->make(true);
    }




    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jumlah' => 'required|integer',
        ]);

        Perkakas::create($request->all());

        return response()->json(['success' => 'Perkakas berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $perkakas = Perkakas::find($id);
        return response()->json($perkakas);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'jumlah' => 'required|integer',
        ]);

        $perkakas = Perkakas::find($id);
        $perkakas->update($request->all());

        return response()->json(['success' => 'Perkakas berhasil diperbarui.']);
    }

    public function delete($id)
    {
        Perkakas::find($id)->delete();
        return response()->json(['success' => 'Perkakas berhasil dihapus.']);
    }
}

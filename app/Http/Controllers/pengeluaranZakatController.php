<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranZakat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengeluaranZakatController extends Controller
{
    public function index()
    {
        $data = PengeluaranZakat::latest();
        return DataTables::of($data)
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'berat' => 'required|numeric',
            'asal' => 'required|string|max:255',
        ]);

        PengeluaranZakat::create($validated);

        return response()->json(['success' => 'Data berhasil disimpan!']);
    }

    public function edit($id)
    {
        $data = PengeluaranZakat::find($id);
        if ($data) {
            return response()->json($data);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'berat' => 'required|numeric',
            'asal' => 'required|string|max:255',
        ]);

        $data = PengeluaranZakat::find($id);
        if ($data) {
            $data->update($validated);
            return response()->json(['success' => 'Data berhasil diperbarui!']);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function destroy($id)
    {
        $data = PengeluaranZakat::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => 'Data berhasil dihapus!']);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}

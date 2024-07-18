<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PengeluaranInfaq;
use Yajra\DataTables\Facades\DataTables;

class PengeluaranInfaqController extends Controller
{
    public function index()
    {
        $data = PengeluaranInfaq::latest()->get();
        return DataTables::of($data)
            ->rawColumns(['aksi'])
            ->make(true);
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama_pengurus' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
        ]);

        PengeluaranInfaq::create($request->all());

        return response()->json(['success' => 'Data berhasil disimpan.']);
    }

    public function edit($id)
    {
        $pengeluaranInfaq = PengeluaranInfaq::findOrFail($id);
        return response()->json($pengeluaranInfaq);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pengurus' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
        ]);

        $pengeluaranInfaq = PengeluaranInfaq::findOrFail($id);
        $pengeluaranInfaq->update($request->all());

        return response()->json(['success' => 'Data berhasil diupdate.']);
    }

    public function destroy($id)
    {
        $pengeluaranInfaq = PengeluaranInfaq::findOrFail($id);
        $pengeluaranInfaq->delete();

        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}

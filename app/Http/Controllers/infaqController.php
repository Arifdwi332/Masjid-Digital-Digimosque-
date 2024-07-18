<?php

namespace App\Http\Controllers;

use App\Models\Infaq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InfaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Infaq::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '<a class="btn btn-primary btn-sm mx-1 btnEdit" href="#" data-id="' . $row->id . '">Edit</a>
                            <a class="btn btn-danger btn-sm mx-1 btnDel" href="#" data-id="' . $row->id . '">Hapus</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('infaq.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengurus' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        Infaq::create($request->all());

        return response()->json(['success' => 'Data berhasil disimpan!']);
    }

    public function edit($id)
    {
        $infaq = Infaq::find($id);
        return response()->json($infaq);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pengurus' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $infaq = Infaq::find($id);
        $infaq->update($request->all());

        return response()->json(['success' => 'Data berhasil diupdate!']);
    }

    public function destroy($id)
    {
        Infaq::find($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}

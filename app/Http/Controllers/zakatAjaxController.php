<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\zakat;
use Yajra\DataTables\Facades\Datatables;

class zakatAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = zakat::orderBy('berat', 'asc');
        return Datatables::of($data)->addIndexColumn()->addColumn('aksi', function ($data) {
            return view('tombol.tombol')->with('data', $data);
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'berat' => $request->berat,
            'tanggal' => $request->tanggal,
            'asal' => $request->asal,
        ];
        zakat::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = zakat::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'bukti' => $request->bukti,
        ];
        zakat::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        zakat::where('id', $id)->delete();
    }
}

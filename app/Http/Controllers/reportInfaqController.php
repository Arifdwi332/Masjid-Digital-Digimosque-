<?php
// app/Http/Controllers/ReportController.php
// app/Http/Controllers/ReportInfaqController.php

namespace App\Http\Controllers;

use App\Models\Infaq;
use App\Models\PengeluaranInfaq;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportInfaqController extends Controller
{


    public function getData()
    {
        $infaq = Infaq::select('nama_pengurus', 'tanggal', 'nominal', 'keterangan')
            ->get()
            ->map(function ($item) {
                $item['jenis'] = 'Pemasukan';
                return $item;
            });

        $pengeluaran = PengeluaranInfaq::select('nama_pengurus', 'tanggal', 'nominal', 'keterangan')
            ->get()
            ->map(function ($item) {
                $item['jenis'] = 'Pengeluaran';
                return $item;
            });

        $data = $infaq->concat($pengeluaran)->all();
        return DataTables::of($data)->make(true);

        $totalPengeluaran = PengeluaranInfaq::sum('nominal');
        $totalPemasukan = infaq::sum('nominal');
        return view('infaq.report', [
            'totalPengeluaran' => $totalPengeluaran,
            'totalPemasukan' => $totalPemasukan,
        ]);
    }
}

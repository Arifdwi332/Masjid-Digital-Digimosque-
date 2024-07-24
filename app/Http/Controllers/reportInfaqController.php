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

        $totalPengeluaran = PengeluaranInfaq::sum('nominal');
        $totalPemasukan = Infaq::sum('nominal');
        $totalInfaqTersisa = $totalPemasukan - $totalPengeluaran;

        return DataTables::of($data)
            ->with([
                'totalPengeluaran' => $totalPengeluaran,
                'totalPemasukan' => $totalPemasukan,
                'totalInfaqTersisa' => $totalInfaqTersisa,
            ])
            ->make(true);
    }
    public function showHome()
    {
        // Menghitung total pengeluaran dan pemasukan
        $totalPengeluaran = PengeluaranInfaq::sum('nominal');
        $totalPemasukan = Infaq::sum('nominal');
        $totalInfaqTersisa = $totalPemasukan - $totalPengeluaran;

        // Data tambahan
        $data = ['name' => 'Arif'];

        // Menggabungkan data tambahan dengan data hasil perhitungan
        return view('home', array_merge($data, compact('totalPengeluaran', 'totalPemasukan', 'totalInfaqTersisa')));
    }
}

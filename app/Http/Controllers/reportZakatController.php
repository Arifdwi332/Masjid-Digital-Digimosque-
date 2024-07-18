<?php

namespace App\Http\Controllers;

use App\Models\PemasukanZakat;
use App\Models\PengeluaranZakat;
use App\Models\zakat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReportZakatController extends Controller
{


    public function getData()
    {
        $pemasukan = zakat::select('nama', 'tanggal', 'berat AS jumlah_berat', 'asal AS keterangan')
            ->get()
            ->map(function ($item) {
                $item['jenis'] = 'Pemasukan';
                return $item;
            });

        $pengeluaran = PengeluaranZakat::select('nama', 'tanggal', 'berat AS jumlah_berat', 'asal AS keterangan')
            ->get()
            ->map(function ($item) {
                $item['jenis'] = 'Pengeluaran';
                return $item;
            });

        $data = $pemasukan->concat($pengeluaran)->all();

        return DataTables::of($data)->make(true);
    }
}

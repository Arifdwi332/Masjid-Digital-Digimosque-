<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengeluaranZakat extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_zakat';

    protected $fillable = [
        'nama',
        'berat',
        'tanggal',
        'asal',
    ];
}

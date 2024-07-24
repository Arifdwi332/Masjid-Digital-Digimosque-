<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zakat extends Model
{
    use HasFactory;
    public $table = "zakat";
    protected $fillable = ['nama_pengurus', 'nama_muzaki', 'tanggal', 'jumlah_orang', 'asal'];
}

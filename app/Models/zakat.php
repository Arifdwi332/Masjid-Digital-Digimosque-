<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Import the Model class
use Illuminate\Database\Eloquent\Factories\HasFactory; // Import the HasFactory trait

class zakat extends Model
{
    use HasFactory;
    public $table = "zakat";
    protected $fillable = ['nama', 'berat', 'tanggal', 'asal'];
}

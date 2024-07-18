<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perkakas extends Model
{
    use HasFactory;

    protected $table = 'perkakas';

    protected $fillable = [
        'nama_item',
        'jumlah',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusNonAktif extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan_terakhir',
        'tahun_nonaktif'
    ];
}

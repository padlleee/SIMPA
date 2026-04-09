<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventarisPeralatan extends Model
{
    use HasFactory;

    protected $table = 'inventaris_peralatan';
    protected $primaryKey = 'id_aset';

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'satuan',
        'kode_barang',
        'lokasi',
        'kondisi',
    ];
}

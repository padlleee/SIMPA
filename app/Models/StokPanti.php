<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokPanti extends Model
{
    use HasFactory;

    protected $table = 'stok_panti';
    protected $primaryKey = 'id_barang';
    // Only has updated_at, no created_at standard
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'kategori_barang',
        'stok_awal',
        'barang_masuk',
        'barang_keluar',
        'stok_akhir',
        'satuan',
        'keterangan',
        'id_admin',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    protected $table      = 'riwayat_stok';
    protected $primaryKey = 'id_riwayat';
    public $timestamps    = false;

    protected $fillable = [
        'id_stok',
        'nama_barang',
        'kategori_barang',
        'satuan',
        'jenis',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'id_admin',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ===================== RELATIONSHIPS =====================

    public function stok()
    {
        return $this->belongsTo(StokPanti::class, 'id_stok', 'id_stok');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }
}

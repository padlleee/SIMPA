<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanBuku extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_buku';
    protected $primaryKey = 'id_pinjam';

    protected $fillable = [
        'id_buku',
        'nama_peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function buku()
    {
        return $this->belongsTo(Perpustakaan::class, 'id_buku', 'id_buku');
    }

    public function scopeDipinjam($query)
    {
        return $query->where('status', 'Dipinjam');
    }

    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'Dikembalikan');
    }
}

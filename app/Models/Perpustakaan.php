<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perpustakaan extends Model
{
    use HasFactory;

    protected $table = 'perpustakaan';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'pengarang',
        'jumlah_buku',
        'kondisi_buku',
    ];

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanBuku::class, 'id_buku', 'id_buku');
    }

    public function peminjamanAktif()
    {
        return $this->hasMany(PeminjamanBuku::class, 'id_buku', 'id_buku')
                    ->where('status', 'Dipinjam');
    }
}

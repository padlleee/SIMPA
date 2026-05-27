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
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'kategori_buku',
        'sinopsis',
        'foto_buku',
        'jumlah_buku',
        'kondisi_buku',
        'is_featured',
        'kategori_landing',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
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

    public function getFotoBukuUrlAttribute(): string
    {
        if ($this->foto_buku && file_exists(public_path('storage/' . $this->foto_buku))) {
            return asset('storage/' . $this->foto_buku);
        }
        return ''; // empty = show placeholder
    }
}

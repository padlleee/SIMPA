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
        'tanggal_dikembalikan', // actual return date
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam'       => 'date',
        'tanggal_kembali'      => 'date',
        'tanggal_dikembalikan' => 'date',
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

    /**
     * Returns true when the loan is overdue (past deadline and still active).
     */
    public function getTerlambatAttribute(): bool
    {
        return $this->status === 'Dipinjam'
            && $this->tanggal_kembali
            && $this->tanggal_kembali->isPast();
    }

    /**
     * Days remaining until deadline (negative = overdue).
     */
    public function getSisaHariAttribute(): int
    {
        if (!$this->tanggal_kembali) return 0;
        return now()->startOfDay()->diffInDays($this->tanggal_kembali->startOfDay(), false);
    }
}

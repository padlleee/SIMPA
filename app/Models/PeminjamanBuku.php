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
        'tipe_peminjam',
        'id_anak_asuh',
        'id_donatur',
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

    public function anakAsuh()
    {
        return $this->belongsTo(AnakAsuh::class, 'id_anak_asuh', 'id_anak');
    }

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'id_donatur', 'id_donatur');
    }

    /**
     * Get the borrower name dynamically.
     */
    public function getNamaPeminjamAttribute($value)
    {
        if ($this->tipe_peminjam === 'Anak Asuh' && $this->anakAsuh) {
            return $this->anakAsuh->nama_anak;
        }
        if ($this->tipe_peminjam === 'Donatur' && $this->donatur) {
            return $this->donatur->nama_donatur;
        }
        return $value;
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

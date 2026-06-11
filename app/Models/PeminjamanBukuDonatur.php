<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanBukuDonatur extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_buku_donatur';

    protected $fillable = [
        'donatur_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'dana_jaminan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pinjam'       => 'date',
        'tanggal_kembali'      => 'date',
        'tanggal_dikembalikan' => 'date',
        'dana_jaminan'         => 'integer',
    ];

    // ── Relationships ────────────────────────────────────────────────────

    /**
     * The donatur who borrowed this book.
     */
    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'donatur_id', 'id_donatur');
    }

    /**
     * The book being borrowed.
     */
    public function buku()
    {
        return $this->belongsTo(Perpustakaan::class, 'buku_id', 'id_buku');
    }

    // ── Scopes ───────────────────────────────────────────────────────────

    public function scopePending($query)    { return $query->where('status', 'Pending'); }
    public function scopeDipinjam($query)   { return $query->where('status', 'Dipinjam'); }
    public function scopeKembali($query)    { return $query->where('status', 'Kembali'); }
    public function scopeDanaHangus($query) { return $query->where('status', 'Dana Hangus'); }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['Pending', 'Dipinjam']);
    }

    // ── Accessors ────────────────────────────────────────────────────────

    /**
     * True when status is 'Dipinjam' and deadline has passed.
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
        return now()->startOfDay()->diffInDays(
            $this->tanggal_kembali->startOfDay(),
            false
        );
    }

    // ── Constants ────────────────────────────────────────────────────────

    public const STATUS_LIST = ['Pending', 'Dipinjam', 'Kembali', 'Dana Hangus'];
}

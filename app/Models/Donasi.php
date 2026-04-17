<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';
    protected $primaryKey = 'id_donasi';
    public $timestamps = false;

    protected $fillable = [
        'id_donatur',
        'nama_donatur_manual',      // for public donations without account
        'nominal',
        'metode_pembayaran',        // Transfer, QRIS, Tunai
        'bukti_pembayaran',         // file path to proof
        'status_verifikasi',        // Pending, Valid, Tolak
        'id_bendahara',             // admin who verified
        'catatan_verifikasi',       // admin notes
        'tanggal_donasi',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'tanggal_donasi' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    // ==================== RELATIONSHIPS ====================

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'id_donatur', 'id_donatur');
    }

    public function bendahara()
    {
        return $this->belongsTo(User::class, 'id_bendahara', 'id_user');
    }

    // ==================== ACCESSORS ====================

    public function getNamaDonaturDisplayAttribute()
    {
        return $this->donatur?->nama_donatur ?? $this->nama_donatur_manual ?? '-';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Pending' => '<span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Menunggu Verifikasi</span>',
            'Valid' => '<span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Terverifikasi</span>',
            'Tolak' => '<span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>',
        ];
        return $badges[$this->status_verifikasi] ?? '-';
    }

    public function getNominalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    // ==================== QUERY SCOPES ====================

    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'Pending');
    }

    public function scopeValid($query)
    {
        return $query->where('status_verifikasi', 'Valid');
    }

    public function scopeTolak($query)
    {
        return $query->where('status_verifikasi', 'Tolak');
    }

    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'Valid');
    }

    public function scopeMonth($query, $month, $year)
    {
        return $query->whereMonth('tanggal_donasi', $month)
                     ->whereYear('tanggal_donasi', $year);
    }

    // ==================== METHODS ====================

    /**
     * Mark donation as verified (approved)
     */
    public function verify($bendaharaId, $catatan = null)
    {
        $this->update([
            'status_verifikasi' => 'Valid',
            'id_bendahara' => $bendaharaId,
            'catatan_verifikasi' => $catatan,
            'tanggal_verifikasi' => now(),
        ]);
        return $this;
    }

    /**
     * Mark donation as rejected
     */
    public function reject($bendaharaId, $catatan = null)
    {
        $this->update([
            'status_verifikasi' => 'Tolak',
            'id_bendahara' => $bendaharaId,
            'catatan_verifikasi' => $catatan,
            'tanggal_verifikasi' => now(),
        ]);
        return $this;
    }

    /**
     * Check if donation is verified
     */
    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'Valid';
    }

    /**
     * Check if donation is pending
     */
    public function isPending(): bool
    {
        return $this->status_verifikasi === 'Pending';
    }

    /**
     * Check if donation is rejected
     */
    public function isRejected(): bool
    {
        return $this->status_verifikasi === 'Tolak';
    }
}


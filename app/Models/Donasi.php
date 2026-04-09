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
        'nama_donatur_manual',  // for public donations without account
        'nominal',
        'metode_pembayaran',    // Transfer, QRIS, Tunai
        'bukti_pembayaran',
        'status_verifikasi',    // Pending, Valid, Tolak
        'tanggal_donasi',
        'id_bendahara',
    ];

    protected $casts = [
        'tanggal_donasi' => 'datetime',
        'nominal'        => 'decimal:2',
    ];

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'id_donatur', 'id_donatur');
    }

    public function bendahara()
    {
        return $this->belongsTo(User::class, 'id_bendahara', 'id_user');
    }

    // Helpers
    public function getNamaDonaturDisplayAttribute()
    {
        return $this->donatur?->nama_donatur ?? $this->nama_donatur_manual ?? '-';
    }

    public function scopePending($query) { return $query->where('status_verifikasi', 'Pending'); }
    public function scopeValid($query)   { return $query->where('status_verifikasi', 'Valid'); }
    public function scopeTolak($query)   { return $query->where('status_verifikasi', 'Tolak'); }
}

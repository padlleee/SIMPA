<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KasMasuk extends Model
{
    use HasFactory;

    protected $table = 'kas_masuk';

    protected $fillable = [
        'sumber_dana',
        'id_referensi_donasi',
        'tanggal',
        'jumlah',
        'keterangan',
        'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'integer',
    ];

    /**
     * The Donasi record this cash entry originated from.
     * Only populated when sumber_dana = 'Donasi'.
     */
    public function donasi()
    {
        return $this->belongsTo(Donasi::class, 'id_referensi_donasi', 'id_donasi');
    }

    /**
     * Admin user who recorded this entry.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh', 'id_user');
    }

    // ── Scopes ──────────────────────────────────────────────────────────

    public function scopeDonasi($query)
    {
        return $query->where('sumber_dana', 'Donasi');
    }

    public function scopeNonDonasi($query)
    {
        return $query->where('sumber_dana', '!=', 'Donasi');
    }

    public function scopePeriode($query, string $dari, string $sampai)
    {
        return $query->whereBetween('tanggal', [$dari, $sampai]);
    }

    // ── Constants ───────────────────────────────────────────────────────

    public const SUMBER_DANA = [
        'Donasi',
        'Penjualan Hasil Karya',
        'Dana Hibah',
        'Subsidi Pemerintah',
        'Infaq/Sedekah',
        'Lainnya',
    ];
}

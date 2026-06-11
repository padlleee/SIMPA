<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrestasiAnak extends Model
{
    use HasFactory;

    protected $table = 'prestasi_anak';

    protected $fillable = [
        'anak_asuh_id',
        'teks_prestasi',
        'tanggal_dicatat',
        'warna_hex',
    ];

    protected $casts = [
        'tanggal_dicatat' => 'date',
    ];

    // Colour palette cycling — assigned automatically when none specified
    public const WARNA_PALETTE = [
        '#4f46e5', // indigo
        '#0891b2', // cyan
        '#059669', // emerald
        '#d97706', // amber
        '#dc2626', // red
        '#7c3aed', // violet
        '#db2777', // pink
        '#65a30d', // lime
    ];

    /**
     * Get a colour from the palette based on a cycling index.
     */
    public static function warnaUntukIndex(int $index): string
    {
        return self::WARNA_PALETTE[$index % count(self::WARNA_PALETTE)];
    }

    // ── Relationships ────────────────────────────────────────────────────

    public function anak()
    {
        return $this->belongsTo(AnakAsuh::class, 'anak_asuh_id', 'id_anak');
    }
}

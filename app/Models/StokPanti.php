<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokPanti extends Model
{
    use HasFactory;

    protected $table = 'stok_panti';
    protected $primaryKey = 'id_stok';
    // Only has updated_at, no created_at standard
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'kategori_barang',
        'merk',               // Brand/manufacturer
        'kode_barang',
        'stok_awal',
        'barang_masuk',
        'barang_keluar',
        'stok_akhir',
        'satuan',
        'tanggal_kadaluarsa', // Expiry date (nullable)
        'keterangan',
        'id_admin',
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
    ];

    // ── Helper ──────────────────────────────────────────────────────────

    /**
     * Generate otomatis kode_barang dengan format BRGMM-DD-XX
     * Contoh: BRG06-08-01 untuk barang pertama tanggal 8 Juni
     */
    public static function generateKodeBarang()
    {
        $prefix = 'BRG' . date('m') . '-' . date('d') . '-';
        
        $lastRecord = self::where('kode_barang', 'like', $prefix . '%')
            ->orderBy('kode_barang', 'desc')
            ->first();
            
        if (! $lastRecord || ! $lastRecord->kode_barang) {
            $number = 1;
        } else {
            $lastNumber = (int) substr($lastRecord->kode_barang, -2);
            $number = $lastNumber + 1;
        }
        
        return $prefix . str_pad($number, 2, '0', STR_PAD_LEFT);
    }

    // ── Scopes ──────────────────────────────────────────────────────────

    /** Items expiring within the given number of days (default: 30). */
    public function scopeAkanKadaluarsa($query, int $hari = 30)
    {
        return $query->whereNotNull('tanggal_kadaluarsa')
                     ->whereDate('tanggal_kadaluarsa', '<=', now()->addDays($hari));
    }

    /** Items already past their expiry date. */
    public function scopeSudahKadaluarsa($query)
    {
        return $query->whereNotNull('tanggal_kadaluarsa')
                     ->whereDate('tanggal_kadaluarsa', '<', now());
    }
}

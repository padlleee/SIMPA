<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventarisPeralatan extends Model
{
    use HasFactory;

    protected $table = 'inventaris_peralatan';
    protected $primaryKey = 'id_aset';

    protected $fillable = [
        'nama_barang',
        'nama_kategori',
        'jumlah',
        'satuan',
        'kode_barang',     // Product-type code (e.g. CHAIR-001)
        'kode_unik_aset',  // Per-unit asset tag (e.g. CHAIR-001/A/001)
        'lokasi',
        'ruangan',         // Enum room assignment for filtering
        'kondisi',
        'gambar',
        'keterangan',
    ];

    public const RUANGAN_LIST = [
        'Kantor',
        'Asrama',
        'Dapur',
        'Aula',
        'Perpustakaan',
        'Ruang Belajar',
        'Gudang',
        'Lainnya',
    ];

    // ── Scopes ──────────────────────────────────────────────────────────

    public function scopeByRuangan($query, string $ruangan)
    {
        return $query->where('ruangan', $ruangan);
    }

    public function scopeUnikAset($query)
    {
        return $query->whereNotNull('kode_unik_aset');
    }
}

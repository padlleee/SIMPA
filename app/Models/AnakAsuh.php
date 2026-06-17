<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnakAsuh extends Model
{
    use HasFactory;

    protected $table = 'anak_asuh';
    protected $primaryKey = 'id_anak';
    public $timestamps = false; // table only has created_at, not updated_at

    protected $fillable = [
        'nama_anak',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',   // 'L' or 'P'
        'pendidikan',
        'kelas',
        'jenis_layanan',
        'dusun',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'status_anak',     // 'Aktif' or 'Alumni'
        'tanggal_masuk',
        'catatan_kesehatan',
        'perkembangan_akademik',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_masuk'  => 'date',
        'created_at'     => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────────────────

    /**
     * Dynamic development-status labels attached to this orphan.
     */
    public function labels()
    {
        return $this->belongsToMany(
            Label::class,
            'anak_asuh_label',
            'anak_asuh_id',
            'label_id',
            'id_anak',
            'id'
        );
    }

    /**
     * Free-text achievement badges (the main development tracking system).
     * Each record is one achievement like "Juara 1 – Lomba MTQ" or "Naik Kelas Sem. 4".
     */
    public function prestasi()
    {
        return $this->hasMany(PrestasiAnak::class, 'anak_asuh_id', 'id_anak')
                    ->orderBy('created_at', 'desc');
    }

    public function scopeAktif($query)  { return $query->where('status_anak', 'Aktif'); }
    public function scopeAlumni($query) { return $query->where('status_anak', 'Alumni'); }

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}

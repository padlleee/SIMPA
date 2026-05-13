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

    public function scopeAktif($query)  { return $query->where('status_anak', 'Aktif'); }
    public function scopeAlumni($query) { return $query->where('status_anak', 'Alumni'); }

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}

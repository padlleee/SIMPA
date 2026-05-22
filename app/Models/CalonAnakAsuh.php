<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalonAnakAsuh extends Model
{
    protected $table = 'calon_anak_asuh';

    protected $fillable = [
        'nama_anak',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_wali',
        'kontak_wali',
        'alasan_masuk',
        'dokumen_path',
        'status',
        'reviewed_by',
        'reviewed_at',
        'catatan_review',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'reviewed_at'   => 'datetime',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * The admin who reviewed this application.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id_user');
    }

    /**
     * Computed age from tanggal_lahir.
     */
    public function getUmurAttribute(): string
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->diffInYears(now()) . ' tahun' : '-';
    }
}

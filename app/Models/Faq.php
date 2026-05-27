<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'kategori',
        'urutan',
    ];

    /**
     * Label display per kategori untuk dipakai di view.
     */
    public static function kategoriLabel(): array
    {
        return [
            'profil'  => 'Profil Panti',
            'donasi'  => 'Sistem Donasi',
            'akun'    => 'Keanggotaan Donatur',
            'layanan' => 'Relawan & Beasiswa',
        ];
    }

    /**
     * Scope default: urutkan by urutan lalu id.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;

    protected $table = 'labels';

    protected $fillable = [
        'nama_label',
        'warna_hex',
    ];

    /**
     * All orphans that carry this label.
     */
    public function anakAsuh()
    {
        return $this->belongsToMany(
            AnakAsuh::class,
            'anak_asuh_label',
            'label_id',
            'anak_asuh_id',
            'id',
            'id_anak'
        );
    }
}

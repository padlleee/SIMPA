<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    public $timestamps = false;

    protected $fillable = [
        'kategori_biaya',       // actual column name
        'keterangan',
        'nominal',              // actual column name (not 'jumlah')
        'tanggal_pengeluaran',  // actual column name
        'id_bendahara',
    ];

    protected $casts = [
        'tanggal_pengeluaran' => 'date',
        'nominal'             => 'decimal:2',
    ];

    public function bendahara()
    {
        return $this->belongsTo(User::class, 'id_bendahara', 'id_user');
    }
}

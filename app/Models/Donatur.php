<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donatur extends Model
{
    use HasFactory;

    protected $table = 'donatur';
    protected $primaryKey = 'id_donatur';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_donatur',
        'email',       // email is on donatur table, not users
        'no_hp',       // actual column name (not nomor_kontak)
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_donatur', 'id_donatur');
    }
}

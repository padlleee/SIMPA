<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;  // users table only has created_at, not updated_at

    protected $dates = ['created_at'];
    protected $fillable = [
        'username',
        'password',
        'role',
        'kode_akses',
        'force_password_change',
        'last_login_at',
        'password_changed_at',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'force_password_change' => 'boolean',
        'last_login_at' => 'datetime',
        'password_changed_at' => 'datetime',
    ];

    /**
     * Laravel's Auth uses 'email' as the default credential field.
     * Override to 'username' since that's the unique key in this DB.
     */
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    public function donatur()
    {
        return $this->hasOne(Donatur::class, 'id_user', 'id_user');
    }

    public function donasiDiverifikasi()
    {
        return $this->hasMany(Donasi::class, 'id_bendahara', 'id_user');
    }

    public function isAdmin()    { return $this->role === 'Admin'; }
    public function isKetua()    { return $this->role === 'Ketua'; }
    public function isDonatur()  { return $this->role === 'Donatur'; }
    public function isBendahara(){ return $this->role === 'Bendahara'; }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Admin ──────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@simpa.com'],
            [
                'username'              => 'Admin SIMPA',
                'password'              => Hash::make('password'),
                'role'                  => 'Admin',
                'kode_akses'            => 'ADM-001',
                'force_password_change' => false,
                'status'                => 'active',
            ]
        );

        // ── 2. Ketua ──────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'ketua@simpa.com'],
            [
                'username'              => 'Ketua Yayasan',
                'password'              => Hash::make('password'),
                'role'                  => 'Ketua',
                'kode_akses'            => 'KET-001',
                'force_password_change' => false,
                'status'                => 'active',
            ]
        );

        // ── 3. Bendahara ──────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'bendahara@simpa.com'],
            [
                'username'              => 'Bendahara Panti',
                'password'              => Hash::make('password'),
                'role'                  => 'Bendahara',
                'kode_akses'            => 'BEN-001',
                'force_password_change' => false,
                'status'                => 'active',
            ]
        );
    }
}

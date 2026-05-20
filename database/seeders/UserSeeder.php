<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Donatur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
            ['email' => 'bendahara@simp.com'],
            [
                'username'              => 'Bendahara Panti',
                'password'              => Hash::make('password'),
                'role'                  => 'Bendahara',
                'kode_akses'            => 'BEN-001',
                'force_password_change' => false,
                'status'                => 'active',
            ]
        );

        // ── 4. Donatur (10 registered donors) ─────────────────
        $donaturData = [
            ['nama' => 'Budi Santoso',     'email' => 'budi.santoso@gmail.com',    'no_hp' => '081234567890', 'kota' => 'Bandung'],
            ['nama' => 'Siti Rahayu',      'email' => 'siti.rahayu@gmail.com',     'no_hp' => '082345678901', 'kota' => 'Jakarta'],
            ['nama' => 'Ahmad Fauzi',      'email' => 'ahmad.fauzi@yahoo.com',     'no_hp' => '083456789012', 'kota' => 'Surabaya'],
            ['nama' => 'Dewi Lestari',     'email' => 'dewi.lestari@gmail.com',    'no_hp' => '084567890123', 'kota' => 'Subang'],
            ['nama' => 'Rudi Hartono',     'email' => 'rudi.hartono@outlook.com',  'no_hp' => '085678901234', 'kota' => 'Purwakarta'],
            ['nama' => 'Rina Susanti',     'email' => 'rina.susanti@gmail.com',    'no_hp' => '086789012345', 'kota' => 'Bogor'],
            ['nama' => 'Hendra Gunawan',   'email' => 'hendra.gunawan@gmail.com',  'no_hp' => '087890123456', 'kota' => 'Bekasi'],
            ['nama' => 'Maya Permata',     'email' => 'maya.permata@yahoo.com',    'no_hp' => '088901234567', 'kota' => 'Depok'],
            ['nama' => 'Wahyu Setiawan',   'email' => 'wahyu.setiawan@gmail.com',  'no_hp' => '089012345678', 'kota' => 'Cianjur'],
            ['nama' => 'Lina Marlina',     'email' => 'lina.marlina@gmail.com',    'no_hp' => '081122334455', 'kota' => 'Karawang'],
        ];

        foreach ($donaturData as $idx => $d) {
            $user = User::updateOrCreate(
                ['email' => $d['email']],
                [
                    'username'              => $d['nama'],
                    'password'              => Hash::make('password'),
                    'role'                  => 'Donatur',
                    'kode_akses'            => 'DON-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                    'force_password_change' => false,
                    'status'                => 'active',
                ]
            );

            Donatur::updateOrCreate(
                ['id_user' => $user->id_user],
                [
                    'nama_donatur' => $d['nama'],
                    'email'        => $d['email'],
                    'no_hp'        => $d['no_hp'],
                    'alamat'       => 'Jl. ' . fake()->streetName() . ', ' . $d['kota'],
                ]
            );
        }
    }
}

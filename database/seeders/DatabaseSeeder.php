<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Donatur;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Check if seeds already exist to prevent duplicates
        if (User::where('username', 'admin')->exists()) {
            $this->command->info('Users already seeded. Skipping.');
            return;
        }

        // Admin Account
        User::create([
            'username' => 'admin',
            'email'    => 'admin@simpa.test',
            'password' => Hash::make('password'),
            'role'     => 'Admin',
        ]);

        // Ketua Yayasan Account
        User::create([
            'username' => 'ketua',
            'email'    => 'ketua@simpa.test',
            'password' => Hash::make('password'),
            'role'     => 'Ketua',
        ]);

        // Bendahara Account
        User::create([
            'username' => 'bendahara',
            'email'    => 'bendahara@simpa.test',
            'password' => Hash::make('password'),
            'role'     => 'Bendahara',
        ]);

        // Donatur Account
        $donaturUser = User::create([
            'username' => 'donatur1',
            'email'    => 'donatur1@simpa.test',
            'password' => Hash::make('password'),
            'role'     => 'Donatur',
        ]);

        Donatur::create([
            'id_user'      => $donaturUser->id_user,
            'nama_donatur' => 'Budi Santoso',
            'email'        => 'budi@example.com',
            'no_hp'        => '081234567890',
            'alamat'       => 'Jl. Contoh No. 10, Kota Anda',
        ]);

        $this->command->info('✓ Users seeded:');
        $this->command->table(
            ['Username', 'Email', 'Role', 'Password'],
            [
                ['admin',     'admin@simpa.test',     'Admin',     'password'],
                ['ketua',     'ketua@simpa.test',     'Ketua',     'password'],
                ['bendahara', 'bendahara@simpa.test', 'Bendahara', 'password'],
                ['donatur1',  'donatur1@simpa.test',  'Donatur',   'password'],
            ]
        );
    }
}

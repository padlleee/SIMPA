<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Run: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $this->command->info('🌱 Memulai seeding database SIMPA...');

        // 1. Users & Donatur (harus pertama karena FK dependency)
        $this->command->comment('  → Membuat akun pengguna & data donatur...');
        $this->call(UserSeeder::class);

        // 2. Anak Asuh
        $this->command->comment('  → Mengisi data anak asuh...');
        $this->call(AnakAsuhSeeder::class);

        // 3. Donasi (butuh users/donatur sudah ada)
        $this->command->comment('  → Mengisi riwayat donasi...');
        $this->call(DonasiSeeder::class);

        // 4. Pengeluaran
        $this->command->comment('  → Mengisi data pengeluaran...');
        $this->call(PengeluaranSeeder::class);

        // 5. Stok & Inventaris
        $this->command->comment('  → Mengisi stok gudang & inventaris peralatan...');
        $this->call(StokInventarisSeeder::class);

        // 6. Perpustakaan
        $this->command->comment('  → Mengisi koleksi buku perpustakaan...');
        $this->call(PerpustakaanSeeder::class);

        $this->command->info('');
        $this->command->info('✅ Seeding selesai! Berikut akun yang tersedia:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',      'admin@simpa.com',      'password'],
                ['Ketua',      'ketua@simpa.com',      'password'],
                ['Bendahara',  'bendahara@simpa.com',  'password'],
                ['Donatur (1–10)', 'budi.santoso@gmail.com ... lina.marlina@gmail.com', 'password'],
            ]
        );
    }
}

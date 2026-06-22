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

        // 1. Seeder Wajib (Selalu dijalankan di mana saja)
        $this->command->info('==========================================');
        $this->command->info('  🚀 DATA WAJIB (PRODUCTION) ');
        $this->command->info('==========================================');
        
        $this->command->comment('  → Membuat akun Administrator...');
        $this->call(UserAdminSeeder::class);
        
        $this->command->comment('  → Mengisi histori data lama...');
        $this->call(OldDataSeeder::class);

        $this->command->comment('  → Mengisi daftar FAQ bawaan...');
        $this->call(FaqSeeder::class);


        // 2. Seeder Dummy (Hanya dijalankan di komputer lokal pengembang)
        if (app()->environment('local')) {
            $this->command->info('');
            $this->command->info('==========================================');
            $this->command->info('  🧪 DATA DUMMY (LOCAL ONLY) ');
            $this->command->info('==========================================');

            $this->command->comment('  → Mengisi akun Donatur dummy...');
            $this->call(UserSeeder::class);

            $this->command->comment('  → Mengisi data anak asuh...');
            $this->call(AnakAsuhSeeder::class);

            $this->command->comment('  → Mengisi riwayat donasi...');
            $this->call(DonasiSeeder::class);

            $this->command->comment('  → Mengisi data pengeluaran...');
            $this->call(PengeluaranSeeder::class);

            $this->command->comment('  ➤ Mengisi stok gudang...');
            $this->call(StokInventarisSeeder::class);

            $this->command->comment('  ➤ Mengisi manajemen peralatan...');
            $this->call(InventarisPeralatanSeeder::class);

            $this->command->comment('  → Mengisi koleksi buku perpustakaan...');
            $this->call(PerpustakaanSeeder::class);

            $this->command->comment('  → Mengisi artikel blog & kegiatan...');
            $this->call(ArticleSeeder::class);

            $this->command->comment('  → Mengisi data pendaftaran calon anak asuh...');
            $this->call(CalonAnakAsuhSeeder::class);
        }

        $this->command->info('');
        $this->command->info('✅ Seeding selesai! Berikut akun Admin yang tersedia:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',      'admin@simpa.com',      'password'],
                ['Ketua',      'ketua@simpa.com',      'password'],
                ['Bendahara',  'bendahara@simpa.com',  'password'],
            ]
        );

        if (app()->environment('local')) {
            $this->command->info('ℹ (Local) Terdapat 10 Akun Donatur: budi.santoso@gmail.com, dll. dengan password "password"');
        }
    }
}


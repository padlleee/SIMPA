<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $pengeluaran = [
            ['keterangan' => 'Pembelian beras 50kg',            'nominal' => 850000,   'kategori' => 'Bahan Makanan'],
            ['keterangan' => 'Pembayaran listrik bulan Januari', 'nominal' => 350000,   'kategori' => 'Utilitas'],
            ['keterangan' => 'Pembelian seragam sekolah',        'nominal' => 2500000,  'kategori' => 'Pendidikan'],
            ['keterangan' => 'Biaya operasional dapur',          'nominal' => 1200000,  'kategori' => 'Bahan Makanan'],
            ['keterangan' => 'Pembelian obat-obatan',            'nominal' => 450000,   'kategori' => 'Kesehatan'],
            ['keterangan' => 'Perbaikan atap gedung asrama',     'nominal' => 5000000,  'kategori' => 'Pemeliharaan'],
            ['keterangan' => 'Pembayaran air PDAM',              'nominal' => 120000,   'kategori' => 'Utilitas'],
            ['keterangan' => 'Biaya buku pelajaran anak',        'nominal' => 1800000,  'kategori' => 'Pendidikan'],
            ['keterangan' => 'Pembelian minyak goreng & gas',    'nominal' => 650000,   'kategori' => 'Bahan Makanan'],
            ['keterangan' => 'Transport kegiatan luar',          'nominal' => 300000,   'kategori' => 'Operasional'],
            ['keterangan' => 'Honorarium pengajar les',          'nominal' => 1500000,  'kategori' => 'Pendidikan'],
            ['keterangan' => 'Pembelian alat tulis',             'nominal' => 275000,   'kategori' => 'Perlengkapan'],
        ];

        foreach ($pengeluaran as $idx => $item) {
            DB::table('pengeluaran')->insert([
                'keterangan'           => $item['keterangan'],
                'nominal'              => $item['nominal'],
                'kategori_biaya'       => $item['kategori'],
                'tanggal_pengeluaran'  => Carbon::now()->subDays(rand(1, 150))->toDateString(),
            ]);
        }

    }
}

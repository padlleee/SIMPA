<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokInventarisSeeder extends Seeder
{
    public function run(): void
    {
        // ── Stok Panti (10 items, 2 kritis) ─────────────────────────────────
        $stokItems = [
            // Normal stock
            ['nama' => 'Beras',             'kat' => 'Bahan Makanan', 'sat' => 'Kg',  'awal' => 100, 'masuk' => 50, 'keluar' => 80,  'minimum' => 20, 'lokasi' => 'Gudang Utama'],
            ['nama' => 'Minyak Goreng',      'kat' => 'Bahan Makanan', 'sat' => 'Ltr', 'awal' => 30,  'masuk' => 20, 'keluar' => 28,  'minimum' => 10, 'lokasi' => 'Dapur'],
            ['nama' => 'Gula Pasir',         'kat' => 'Bahan Makanan', 'sat' => 'Kg',  'awal' => 20,  'masuk' => 15, 'keluar' => 18,  'minimum' => 5,  'lokasi' => 'Dapur'],
            ['nama' => 'Mie Instan',         'kat' => 'Bahan Makanan', 'sat' => 'Dus', 'awal' => 10,  'masuk' => 5,  'keluar' => 6,   'minimum' => 3,  'lokasi' => 'Gudang Utama'],
            ['nama' => 'Sabun Mandi',        'kat' => 'Kebersihan',    'sat' => 'Pcs', 'awal' => 60,  'masuk' => 30, 'keluar' => 50,  'minimum' => 15, 'lokasi' => 'Gudang Utama'],
            ['nama' => 'Deterjen',           'kat' => 'Kebersihan',    'sat' => 'Kg',  'awal' => 15,  'masuk' => 10, 'keluar' => 12,  'minimum' => 5,  'lokasi' => 'Gudang Utama'],
            ['nama' => 'Obat P3K',           'kat' => 'Kesehatan',     'sat' => 'Paket','awal'=> 5,   'masuk' => 3,  'keluar' => 2,   'minimum' => 2,  'lokasi' => 'Ruang UKS'],
            ['nama' => 'Galon Air',          'kat' => 'Minuman',       'sat' => 'Galon','awal'=> 8,   'masuk' => 4,  'keluar' => 6,   'minimum' => 3,  'lokasi' => 'Dapur'],
            // KRITIS (stok_akhir <= 5)
            ['nama' => 'Gas LPG 3kg',        'kat' => 'Energi',        'sat' => 'Tabung','awal'=>6,   'masuk' => 2,  'keluar' => 7,   'minimum' => 3,  'lokasi' => 'Dapur'],
            ['nama' => 'Sabun Cuci Tangan',  'kat' => 'Kebersihan',    'sat' => 'Botol','awal'=> 10,  'masuk' => 2,  'keluar' => 11,  'minimum' => 5,  'lokasi' => 'Toilet'],
        ];

        foreach ($stokItems as $idx => $item) {
            $stokAkhir = $item['awal'] + $item['masuk'] - $item['keluar'];
            DB::table('stok_panti')->insert([
                'kode_barang'    => 'STK-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'nama_barang'    => $item['nama'],
                'kategori_barang'=> $item['kat'],
                'satuan'         => $item['sat'],
                'stok_awal'      => $item['awal'],
                'barang_masuk'   => $item['masuk'],
                'barang_keluar'  => $item['keluar'],
                'stok_akhir'     => max(0, $stokAkhir),
                'stok_minimum'   => $item['minimum'],
                'lokasi'         => $item['lokasi'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ── Inventaris Peralatan (10 items, mix kondisi) ─────────────────────
        $inventarisItems = [
            ['nama' => 'Meja Belajar',      'jml' => 20, 'sat' => 'Buah', 'lokasi' => 'Ruang Belajar',  'kondisi' => 'Baik'],
            ['nama' => 'Kursi Plastik',     'jml' => 30, 'sat' => 'Buah', 'lokasi' => 'Ruang Makan',    'kondisi' => 'Baik'],
            ['nama' => 'Lemari Pakaian',    'jml' => 6,  'sat' => 'Buah', 'lokasi' => 'Kamar Tidur',    'kondisi' => 'Baik'],
            ['nama' => 'Laptop',            'jml' => 2,  'sat' => 'Unit', 'lokasi' => 'Kantor',          'kondisi' => 'Baik'],
            ['nama' => 'Printer',           'jml' => 1,  'sat' => 'Unit', 'lokasi' => 'Kantor',          'kondisi' => 'Rusak'],
            ['nama' => 'Kipas Angin',       'jml' => 8,  'sat' => 'Unit', 'lokasi' => 'Asrama',          'kondisi' => 'Baik'],
            ['nama' => 'Kasur Spring Bed',  'jml' => 15, 'sat' => 'Buah', 'lokasi' => 'Kamar Tidur',    'kondisi' => 'Baik'],
            ['nama' => 'Papan Tulis',       'jml' => 3,  'sat' => 'Buah', 'lokasi' => 'Ruang Belajar',  'kondisi' => 'Baik'],
            ['nama' => 'TV LED 32"',        'jml' => 2,  'sat' => 'Unit', 'lokasi' => 'Ruang Keluarga', 'kondisi' => 'Rusak'],
            ['nama' => 'Kulkas',            'jml' => 1,  'sat' => 'Unit', 'lokasi' => 'Dapur',           'kondisi' => 'Baik'],
        ];

        foreach ($inventarisItems as $idx => $item) {
            DB::table('inventaris_peralatan')->insert([
                'kode_barang'  => 'INV-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'nama_barang'  => $item['nama'],
                'jumlah'       => $item['jml'],
                'satuan'       => $item['sat'],
                'lokasi'       => $item['lokasi'],
                'kondisi'      => $item['kondisi'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Seed gudang sembako panti dengan data realistis.
 * Satu barang → satu baris (satu kode).
 * Merk & tanggal kadaluarsa dicatat sebagai informasi tambahan.
 * Semua mutasi juga dicatat di riwayat_stok.
 */
class StokInventarisSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil id_user admin untuk dicatat sebagai id_admin
        $adminId = DB::table('users')->where('role', 'Admin')->value('id_user') ?? 1;

        DB::table('stok_panti')->truncate();
        DB::table('riwayat_stok')->truncate();

        $now = now();

        // ─────────────────────────────────────────────────────────────────
        // Data sembako gudang panti — satu kode per jenis barang
        // ─────────────────────────────────────────────────────────────────
        $items = [
            // Barang utama — aman
            [
                'nama_barang'        => 'Beras',
                'kategori_barang'    => 'Sembako',
                'merk'               => 'Rose Brand',
                'satuan'             => 'Kg',
                'stok_awal'          => 100,
                'barang_masuk'       => 150,
                'barang_keluar'      => 120,
                'tanggal_kadaluarsa' => null,
                'keterangan'         => 'Stok beras utama panti',
            ],
            [
                'nama_barang'        => 'Minyak Goreng',
                'kategori_barang'    => 'Sembako',
                'merk'               => 'Bimoli',
                'satuan'             => 'Liter',
                'stok_awal'          => 40,
                'barang_masuk'       => 60,
                'barang_keluar'      => 55,
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(8)->format('Y-m-d'),
                'keterangan'         => 'Stok minyak goreng dapur',
            ],
            [
                'nama_barang'        => 'Gula Pasir',
                'kategori_barang'    => 'Sembako',
                'merk'               => 'Gulaku',
                'satuan'             => 'Kg',
                'stok_awal'          => 30,
                'barang_masuk'       => 40,
                'barang_keluar'      => 35,
                'tanggal_kadaluarsa' => null,
                'keterangan'         => null,
            ],
            [
                'nama_barang'        => 'Mie Instan',
                'kategori_barang'    => 'Sembako',
                'merk'               => 'Indomie',
                'satuan'             => 'Dus',
                'stok_awal'          => 20,
                'barang_masuk'       => 30,
                'barang_keluar'      => 28,
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(6)->format('Y-m-d'),
                'keterangan'         => 'Mie instan untuk santap siang cadangan',
            ],
            [
                'nama_barang'        => 'Tepung Terigu',
                'kategori_barang'    => 'Sembako',
                'merk'               => 'Segitiga Biru',
                'satuan'             => 'Kg',
                'stok_awal'          => 25,
                'barang_masuk'       => 25,
                'barang_keluar'      => 20,
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(5)->format('Y-m-d'),
                'keterangan'         => null,
            ],
            [
                'nama_barang'        => 'Garam',
                'kategori_barang'    => 'Sembako',
                'merk'               => 'Refina',
                'satuan'             => 'Kg',
                'stok_awal'          => 10,
                'barang_masuk'       => 10,
                'barang_keluar'      => 8,
                'tanggal_kadaluarsa' => null,
                'keterangan'         => null,
            ],

            // Kebersihan
            [
                'nama_barang'        => 'Sabun Mandi',
                'kategori_barang'    => 'Kebersihan',
                'merk'               => 'Lifebuoy',
                'satuan'             => 'Pcs',
                'stok_awal'          => 60,
                'barang_masuk'       => 80,
                'barang_keluar'      => 75,
                'tanggal_kadaluarsa' => Carbon::now()->addYears(2)->format('Y-m-d'),
                'keterangan'         => null,
            ],
            [
                'nama_barang'        => 'Deterjen',
                'kategori_barang'    => 'Kebersihan',
                'merk'               => 'Rinso',
                'satuan'             => 'Kg',
                'stok_awal'          => 20,
                'barang_masuk'       => 20,
                'barang_keluar'      => 18,
                'tanggal_kadaluarsa' => null,
                'keterangan'         => null,
            ],
            [
                'nama_barang'        => 'Sabun Cuci Tangan',
                'kategori_barang'    => 'Kebersihan',
                'merk'               => 'Dettol',
                'satuan'             => 'Botol',
                'stok_awal'          => 12,
                'barang_masuk'       => 12,
                'barang_keluar'      => 11,
                // SEGERA KADALUARSA — dalam 20 hari
                'tanggal_kadaluarsa' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'keterangan'         => 'Perlu segera restock',
            ],

            // Kesehatan
            [
                'nama_barang'        => 'Obat P3K',
                'kategori_barang'    => 'Kesehatan',
                'merk'               => null,
                'satuan'             => 'Paket',
                'stok_awal'          => 5,
                'barang_masuk'       => 5,
                'barang_keluar'      => 4,
                'tanggal_kadaluarsa' => Carbon::now()->addYear()->format('Y-m-d'),
                'keterangan'         => 'Kotak P3K UKS',
            ],
            [
                'nama_barang'        => 'Vitamin C',
                'kategori_barang'    => 'Kesehatan',
                'merk'               => 'Enervon-C',
                'satuan'             => 'Box',
                'stok_awal'          => 10,
                'barang_masuk'       => 10,
                'barang_keluar'      => 9,
                // KRITIS — stok akhir = 1
                'tanggal_kadaluarsa' => Carbon::now()->addMonths(10)->format('Y-m-d'),
                'keterangan'         => null,
            ],

            // Minuman & Energi
            [
                'nama_barang'        => 'Galon Air',
                'kategori_barang'    => 'Minuman',
                'merk'               => 'Club',
                'satuan'             => 'Galon',
                'stok_awal'          => 10,
                'barang_masuk'       => 15,
                'barang_keluar'      => 12,
                'tanggal_kadaluarsa' => null,
                'keterangan'         => null,
            ],
            [
                'nama_barang'        => 'Gas LPG 3kg',
                'kategori_barang'    => 'Energi',
                'merk'               => null,
                'satuan'             => 'Tabung',
                'stok_awal'          => 6,
                'barang_masuk'       => 6,
                'barang_keluar'      => 9,
                // KRITIS — stok akhir = 3
                'tanggal_kadaluarsa' => null,
                'keterangan'         => 'Cek tekanan sebelum dipakai',
            ],

            // KADALUARSA — sengaja untuk demonstrasi badge merah
            [
                'nama_barang'        => 'Kecap Manis',
                'kategori_barang'    => 'Sembako',
                'merk'               => 'ABC',
                'satuan'             => 'Botol',
                'stok_awal'          => 8,
                'barang_masuk'       => 8,
                'barang_keluar'      => 4,
                // SUDAH KADALUARSA
                'tanggal_kadaluarsa' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'keterangan'         => 'Perlu segera dibuang / dimusnahkan',
            ],
        ];

        foreach ($items as $idx => $item) {
            $stokAkhir = $item['stok_awal'] + $item['barang_masuk'] - $item['barang_keluar'];

            // Generate kode barang format BRGMM-DD-XX
            // Untuk seeder gunakan tanggal sebulan lalu agar realistis
            $seedDate  = now()->subDays(30)->format('md'); // "0508"
            $kodeBarang = 'BRG' . substr($seedDate, 0, 2) . '-' . substr($seedDate, 2, 2) . '-' . str_pad($idx + 1, 2, '0', STR_PAD_LEFT);

            $id = DB::table('stok_panti')->insertGetId([
                'nama_barang'        => $item['nama_barang'],
                'kategori_barang'    => $item['kategori_barang'],
                'kode_barang'        => $kodeBarang,
                'merk'               => $item['merk'],
                'satuan'             => $item['satuan'],
                'stok_awal'          => $item['stok_awal'],
                'barang_masuk'       => $item['barang_masuk'],
                'barang_keluar'      => $item['barang_keluar'],
                'stok_akhir'         => max(0, $stokAkhir),
                'tanggal_kadaluarsa' => $item['tanggal_kadaluarsa'],
                'keterangan'         => $item['keterangan'],
                'id_admin'           => $adminId,
            ]);

            // Catat riwayat masuk awal (seeding)
            if ($item['barang_masuk'] > 0) {
                DB::table('riwayat_stok')->insert([
                    'id_stok'         => $id,
                    'nama_barang'     => $item['nama_barang'],
                    'kategori_barang' => $item['kategori_barang'],
                    'satuan'          => $item['satuan'],
                    'jenis'           => 'Masuk',
                    'jumlah'          => $item['barang_masuk'],
                    'stok_sebelum'    => $item['stok_awal'],
                    'stok_sesudah'    => $item['stok_awal'] + $item['barang_masuk'],
                    'keterangan'      => '[Seeder] Pengisian awal ' . $item['nama_barang'],
                    'id_admin'        => $adminId,
                    'created_at'      => $now->copy()->subDays(30 - $idx),
                ]);
            }

            // Catat riwayat keluar
            if ($item['barang_keluar'] > 0) {
                DB::table('riwayat_stok')->insert([
                    'id_stok'         => $id,
                    'nama_barang'     => $item['nama_barang'],
                    'kategori_barang' => $item['kategori_barang'],
                    'satuan'          => $item['satuan'],
                    'jenis'           => 'Keluar',
                    'jumlah'          => $item['barang_keluar'],
                    'stok_sebelum'    => $item['stok_awal'] + $item['barang_masuk'],
                    'stok_sesudah'    => max(0, $stokAkhir),
                    'keterangan'      => '[Seeder] Pemakaian operasional ' . $item['nama_barang'],
                    'id_admin'        => $adminId,
                    'created_at'      => $now->copy()->subDays(15 - $idx),
                ]);
            }
        }

        $this->command->info('  ✅ StokInventarisSeeder: ' . count($items) . ' barang + ' . (count($items) * 2) . ' entri riwayat gudang berhasil dibuat.');
    }
}

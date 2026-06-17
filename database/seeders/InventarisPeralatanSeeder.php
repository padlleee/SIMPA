<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InventarisPeralatanSeeder extends Seeder
{
    /**
     * Data inventaris peralatan panti dengan keterangan per-unit (berbeda lokasi/kondisi).
     * Gambar diambil dari placeholder service (tidak memerlukan file gambar asli).
     */
    public function run(): void
    {
        // Buat folder storage jika belum ada
        $storagePath = storage_path('app/public/inventaris');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        // Wipe old data first to avoid duplicate unique constraints during reseeding
        DB::table('inventaris_peralatan')->truncate();

        $items = [
            // DAPUR
            [
                'kode_barang'  => 'MT-0001',
                'nama_kategori'=> 'Kulkas',
                'nama_barang'  => 'Kulkas 2 Pintu LG',
                'jumlah'       => 1,
                'satuan'       => 'Unit',
                'ruangan'      => 'Dapur',
                'lokasi'       => 'Dapur Utama',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kulkas 2 pintu untuk menyimpan bahan makanan segar.',
                'img_seed'     => 'refrigerator,kitchen',
            ],
            [
                'kode_barang'  => 'MT-0002',
                'nama_kategori'=> 'Rak Piring',
                'nama_barang'  => 'Rak Piring Aluminium 3 Susun',
                'jumlah'       => 2,
                'satuan'       => 'Buah',
                'ruangan'      => 'Dapur',
                'lokasi'       => 'Dapur Utama',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Rak piring untuk menyimpan peralatan makan santri.',
                'img_seed'     => 'dish rack,kitchen',
            ],
            [
                'kode_barang'  => 'MT-0003',
                'nama_kategori'=> 'Peralatan Masak',
                'nama_barang'  => 'Set Pisau Dapur Stainless',
                'jumlah'       => 5,
                'satuan'       => 'Buah',
                'ruangan'      => 'Dapur',
                'lokasi'       => 'Dapur Utama',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Pisau potong sayur dan daging.',
                'img_seed'     => 'knife,kitchen',
            ],
            [
                'kode_barang'  => 'MT-0004',
                'nama_kategori'=> 'Peralatan Masak',
                'nama_barang'  => 'Panci Besar 50L',
                'jumlah'       => 2,
                'satuan'       => 'Buah',
                'ruangan'      => 'Dapur',
                'lokasi'       => 'Dapur Utama',
                'kondisi'      => 'Rusak',
                'keterangan'   => 'Pegangan panci lepas, butuh perbaikan las.',
                'img_seed'     => 'cooking pot,kitchen',
            ],

            // KANTOR
            [
                'kode_barang'  => 'MT-0005',
                'nama_kategori'=> 'Meja Kerja',
                'nama_barang'  => 'Meja Staff Administrasi',
                'jumlah'       => 3,
                'satuan'       => 'Buah',
                'ruangan'      => 'Kantor',
                'lokasi'       => 'Ruang Tata Usaha',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Meja kayu ukuran standar.',
                'img_seed'     => 'office desk,table',
            ],
            [
                'kode_barang'  => 'MT-0006',
                'nama_kategori'=> 'Laptop',
                'nama_barang'  => 'Laptop ASUS Office',
                'jumlah'       => 2,
                'satuan'       => 'Unit',
                'ruangan'      => 'Kantor',
                'lokasi'       => 'Ruang Tata Usaha',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Laptop operasional pengurus panti.',
                'img_seed'     => 'laptop,computer',
            ],

            // RUANG BELAJAR
            [
                'kode_barang'  => 'MT-0007',
                'nama_kategori'=> 'Papan Tulis',
                'nama_barang'  => 'Whiteboard 2x1 Meter',
                'jumlah'       => 1,
                'satuan'       => 'Buah',
                'ruangan'      => 'Ruang Belajar',
                'lokasi'       => 'Kelas Utama',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Papan tulis lengkap dengan penghapus.',
                'img_seed'     => 'whiteboard,classroom',
            ],
            [
                'kode_barang'  => 'MT-0008',
                'nama_kategori'=> 'Meja Belajar',
                'nama_barang'  => 'Meja Lipat Santri',
                'jumlah'       => 20,
                'satuan'       => 'Buah',
                'ruangan'      => 'Ruang Belajar',
                'lokasi'       => 'Kelas Utama',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Meja lipat kayu untuk belajar santri.',
                'img_seed'     => 'study desk,table',
            ],

            // ASRAMA
            [
                'kode_barang'  => 'MT-0009',
                'nama_kategori'=> 'Kasur Spring Bed',
                'nama_barang'  => 'Kasur Busa Single',
                'jumlah'       => 10,
                'satuan'       => 'Buah',
                'ruangan'      => 'Asrama',
                'lokasi'       => 'Kamar Santri Putra',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kasur busa tebal standar asrama.',
                'img_seed'     => 'mattress,bed',
            ],
            [
                'kode_barang'  => 'MT-0010',
                'nama_kategori'=> 'Lemari Pakaian',
                'nama_barang'  => 'Lemari Plastik 4 Susun',
                'jumlah'       => 5,
                'satuan'       => 'Buah',
                'ruangan'      => 'Asrama',
                'lokasi'       => 'Kamar Santri Putra',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Lemari plastik untuk baju santri.',
                'img_seed'     => 'plastic wardrobe,cabinet',
            ],
        ];

        $totalInserted = 0;

        foreach ($items as $item) {
            // Buat placeholder gambar menggunakan via.placeholder.com
            $imgSeed = urlencode($item['img_seed']);
            $colors = ['4F46E5', '0891B2', '059669', 'D97706', 'DC2626', '7C3AED', '0F766E'];
            $color = $colors[array_rand($colors)];
            $imgUrl = "https://placehold.co/400x300/{$color}/FFFFFF/png?text=" . str_replace(' ', '+', $item['nama_barang']);

            $gambarPath = null;
            try {
                $response = Http::timeout(5)->get($imgUrl);
                if ($response->successful()) {
                    $filename = 'inventaris/' . Str::slug($item['kode_barang']) . '.png';
                    $fullPath = storage_path('app/public/' . $filename);
                    File::put($fullPath, $response->body());
                    $gambarPath = $filename;
                }
            } catch (\Exception $e) {
                // Gambar gagal diunduh, lanjutkan tanpa gambar
            }

            // Expand each quantity into individual records to match new architecture
            $jumlahBarang = $item['jumlah'];
            for ($i = 0; $i < $jumlahBarang; $i++) {
                $kodeUnik = $item['kode_barang'] . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                
                DB::table('inventaris_peralatan')->insert([
                    'kode_barang'   => $item['kode_barang'],
                    'kode_unik_aset'=> $kodeUnik,
                    'nama_kategori' => $item['nama_kategori'],
                    'nama_barang'   => $item['nama_barang'],
                    'jumlah'        => 1, // Must be 1 for new architecture
                    'satuan'        => $item['satuan'],
                    'ruangan'       => $item['ruangan'],
                    'lokasi'        => $item['lokasi'],
                    'kondisi'       => $item['kondisi'],
                    'gambar'        => $gambarPath,
                    'keterangan'    => $item['keterangan'] . ($jumlahBarang > 1 ? " (Unit #" . ($i + 1) . ")" : ""),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
                $totalInserted++;
            }
        }

        $kategoriUnik = count(array_unique(array_column($items, 'nama_kategori')));
        $this->command->info("  ✓ Inventaris Peralatan: $totalInserted unit fisik berhasil di-seed dalam $kategoriUnik kategori berbeda.");
    }
}

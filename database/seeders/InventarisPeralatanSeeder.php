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

        $items = [
            // Meja Tamu — 2 unit, lokasi berbeda, kondisi berbeda
            [
                'kode_barang'  => 'MT-0001',
                'nama_kategori'=> 'Meja Tamu',
                'nama_barang'  => 'Meja Tamu Kayu Jati',
                'jumlah'       => 1,
                'satuan'       => 'Buah',
                'lokasi'       => 'Ruang Makan',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Meja tamu kayu jati ukuran 120x60 cm. Kondisi baik, tidak ada goresan berarti.',
                'img_seed'     => 'desk,office,furniture',
            ],
            [
                'kode_barang'  => 'MT-0002',
                'nama_kategori'=> 'Meja Tamu',
                'nama_barang'  => 'Meja Tamu Kayu Biasa',
                'jumlah'       => 1,
                'satuan'       => 'Buah',
                'lokasi'       => 'Selasar',
                'kondisi'      => 'Rusak',
                'keterangan'   => 'Kaki meja sebelah kanan patah, permukaan atas terdapat goresan panjang. Perlu perbaikan segera.',
                'img_seed'     => 'broken,table,damage',
            ],

            // Meja Belajar
            [
                'kode_barang'  => 'MT-0003',
                'nama_kategori'=> 'Meja Belajar',
                'nama_barang'  => 'Meja Belajar Siswa (Lantai 1)',
                'jumlah'       => 15,
                'satuan'       => 'Buah',
                'lokasi'       => 'Ruang Belajar Lantai 1',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Meja belajar siswa ukuran 60x40 cm. Semua dalam kondisi baik dan layak pakai.',
                'img_seed'     => 'study,desk,school',
            ],
            [
                'kode_barang'  => 'MT-0004',
                'nama_kategori'=> 'Meja Belajar',
                'nama_barang'  => 'Meja Belajar Siswa (Lantai 2)',
                'jumlah'       => 5,
                'satuan'       => 'Buah',
                'lokasi'       => 'Ruang Belajar Lantai 2',
                'kondisi'      => 'Rusak',
                'keterangan'   => '5 meja mengalami kerusakan ringan pada permukaan dan engsel laci. Masih dapat digunakan dengan hati-hati.',
                'img_seed'     => 'classroom,furniture',
            ],

            // Kursi Plastik
            [
                'kode_barang'  => 'MT-0005',
                'nama_kategori'=> 'Kursi Plastik',
                'nama_barang'  => 'Kursi Plastik Merah (Ruang Makan)',
                'jumlah'       => 20,
                'satuan'       => 'Buah',
                'lokasi'       => 'Ruang Makan',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kursi plastik warna merah untuk ruang makan. Semua dalam kondisi prima.',
                'img_seed'     => 'plastic,chair,dining',
            ],
            [
                'kode_barang'  => 'MT-0006',
                'nama_kategori'=> 'Kursi Plastik',
                'nama_barang'  => 'Kursi Plastik Cadangan (Aula)',
                'jumlah'       => 8,
                'satuan'       => 'Buah',
                'lokasi'       => 'Aula',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kursi plastik cadangan di aula untuk kegiatan acara/rapat.',
                'img_seed'     => 'chair,hall,event',
            ],
            [
                'kode_barang'  => 'MT-0007',
                'nama_kategori'=> 'Kursi Plastik',
                'nama_barang'  => 'Kursi Plastik Teras',
                'jumlah'       => 5,
                'satuan'       => 'Buah',
                'lokasi'       => 'Teras',
                'kondisi'      => 'Rusak',
                'keterangan'   => '5 kursi mengalami retak pada sandaran dan kaki akibat paparan cuaca. Tidak aman digunakan.',
                'img_seed'     => 'outdoor,chair,broken',
            ],

            // Lemari Pakaian
            [
                'kode_barang'  => 'MT-0008',
                'nama_kategori'=> 'Lemari Pakaian',
                'nama_barang'  => 'Lemari Pakaian 3 Pintu (Putra)',
                'jumlah'       => 4,
                'satuan'       => 'Buah',
                'lokasi'       => 'Kamar Tidur Putra',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Lemari 3 pintu kayu. Dikondisikan untuk penyimpanan pakaian anak asuh putra.',
                'img_seed'     => 'wardrobe,bedroom,wooden',
            ],
            [
                'kode_barang'  => 'MT-0009',
                'nama_kategori'=> 'Lemari Pakaian',
                'nama_barang'  => 'Lemari Pakaian 2 Pintu (Putri)',
                'jumlah'       => 2,
                'satuan'       => 'Buah',
                'lokasi'       => 'Kamar Tidur Putri',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Lemari 2 pintu kayu untuk anak asuh putri. Kondisi baik, engsel pintu berfungsi normal.',
                'img_seed'     => 'wardrobe,closet',
            ],

            // Laptop
            [
                'kode_barang'  => 'MT-0010',
                'nama_kategori'=> 'Laptop',
                'nama_barang'  => 'Laptop ASUS Vivobook (Kantor)',
                'jumlah'       => 2,
                'satuan'       => 'Unit',
                'lokasi'       => 'Kantor Administrasi',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Laptop untuk operasional administrasi yayasan. Merk ASUS, RAM 8GB, SSD 256GB.',
                'img_seed'     => 'laptop,computer,office',
            ],
            [
                'kode_barang'  => 'MT-0011',
                'nama_kategori'=> 'Laptop',
                'nama_barang'  => 'Laptop Belajar (Rusak)',
                'jumlah'       => 1,
                'satuan'       => 'Unit',
                'lokasi'       => 'Ruang Belajar Lantai 1',
                'kondisi'      => 'Rusak',
                'keterangan'   => 'Layar laptop retak, keyboard beberapa tombol tidak berfungsi. Perlu perbaikan ke service center.',
                'img_seed'     => 'laptop,broken,damage',
            ],

            // Kipas Angin
            [
                'kode_barang'  => 'MT-0012',
                'nama_kategori'=> 'Kipas Angin',
                'nama_barang'  => 'Kipas Angin Berdiri Asrama Putra',
                'jumlah'       => 5,
                'satuan'       => 'Unit',
                'lokasi'       => 'Asrama Putra',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kipas angin berdiri 16", semua berfungsi dengan baik. Dibersihkan rutin setiap bulan.',
                'img_seed'     => 'fan,electric,room',
            ],
            [
                'kode_barang'  => 'MT-0013',
                'nama_kategori'=> 'Kipas Angin',
                'nama_barang'  => 'Kipas Angin Dinding Asrama Putri',
                'jumlah'       => 3,
                'satuan'       => 'Unit',
                'lokasi'       => 'Asrama Putri',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kipas angin dinding di asrama putri. Semua berfungsi normal.',
                'img_seed'     => 'fan,wall,ventilation',
            ],

            // TV LED
            [
                'kode_barang'  => 'MT-0014',
                'nama_kategori'=> 'TV LED',
                'nama_barang'  => 'TV LED 32" Ruang Keluarga',
                'jumlah'       => 1,
                'satuan'       => 'Unit',
                'lokasi'       => 'Ruang Keluarga',
                'kondisi'      => 'Baik',
                'keterangan'   => 'TV LED 32 inci, terhubung antena dan Netflix. Digunakan untuk kegiatan bersama.',
                'img_seed'     => 'television,led,living room',
            ],
            [
                'kode_barang'  => 'MT-0015',
                'nama_kategori'=> 'TV LED',
                'nama_barang'  => 'TV LED 32" Ruang Belajar',
                'jumlah'       => 1,
                'satuan'       => 'Unit',
                'lokasi'       => 'Ruang Belajar Lantai 2',
                'kondisi'      => 'Rusak',
                'keterangan'   => 'Layar menampilkan garis vertikal, remote tidak berfungsi. Sudah dilaporkan untuk perbaikan.',
                'img_seed'     => 'tv,screen,broken',
            ],

            // Kulkas
            [
                'kode_barang'  => 'MT-0016',
                'nama_kategori'=> 'Kulkas',
                'nama_barang'  => 'Kulkas 2 Pintu Dapur',
                'jumlah'       => 1,
                'satuan'       => 'Unit',
                'lokasi'       => 'Dapur',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kulkas 2 pintu 200L. Berfungsi normal untuk penyimpanan bahan makanan harian.',
                'img_seed'     => 'refrigerator,kitchen,appliance',
            ],

            // Kasur
            [
                'kode_barang'  => 'MT-0017',
                'nama_kategori'=> 'Kasur Spring Bed',
                'nama_barang'  => 'Kasur Spring Bed Single (Putra)',
                'jumlah'       => 10,
                'satuan'       => 'Buah',
                'lokasi'       => 'Kamar Tidur Putra',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kasur spring bed ukuran single 90x200 cm. Semua dalam kondisi baik.',
                'img_seed'     => 'mattress,bed,bedroom',
            ],
            [
                'kode_barang'  => 'MT-0018',
                'nama_kategori'=> 'Kasur Spring Bed',
                'nama_barang'  => 'Kasur Spring Bed Single (Putri)',
                'jumlah'       => 5,
                'satuan'       => 'Buah',
                'lokasi'       => 'Kamar Tidur Putri',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Kasur spring bed ukuran single di kamar putri. Dilengkapi bed cover.',
                'img_seed'     => 'bed,pillow,sleep',
            ],

            // Papan Tulis
            [
                'kode_barang'  => 'MT-0019',
                'nama_kategori'=> 'Papan Tulis',
                'nama_barang'  => 'Whiteboard 120x80 cm (Lantai 1)',
                'jumlah'       => 2,
                'satuan'       => 'Buah',
                'lokasi'       => 'Ruang Belajar Lantai 1',
                'kondisi'      => 'Baik',
                'keterangan'   => 'Whiteboard 120x80 cm dengan tripod. Dilengkapi spidol dan penghapus.',
                'img_seed'     => 'whiteboard,classroom,teaching',
            ],
            [
                'kode_barang'  => 'MT-0020',
                'nama_kategori'=> 'Papan Tulis',
                'nama_barang'  => 'Whiteboard (Lantai 2 - Ghosting)',
                'jumlah'       => 1,
                'satuan'       => 'Buah',
                'lokasi'       => 'Ruang Belajar Lantai 2',
                'kondisi'      => 'Rusak',
                'keterangan'   => 'Whiteboard mengalami permukaan yang sulit dihapus (ghosting). Perlu diganti baru.',
                'img_seed'     => 'board,chalk,school',
            ],

            // Printer
            [
                'kode_barang'  => 'MT-0021',
                'nama_kategori'=> 'Printer',
                'nama_barang'  => 'Printer Canon Inkjet (Kantor)',
                'jumlah'       => 1,
                'satuan'       => 'Unit',
                'lokasi'       => 'Kantor Administrasi',
                'kondisi'      => 'Rusak',
                'keterangan'   => 'Printer Canon inkjet mengalami paper jam dan cartridge error. Sedang dalam antrean servis.',
                'img_seed'     => 'printer,office,machine',
            ],
        ];

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

            DB::table('inventaris_peralatan')->insert([
                'kode_barang'   => $item['kode_barang'],
                'nama_kategori' => $item['nama_kategori'],
                'nama_barang'   => $item['nama_barang'],
                'jumlah'        => $item['jumlah'],
                'satuan'        => $item['satuan'],
                'lokasi'        => $item['lokasi'],
                'kondisi'       => $item['kondisi'],
                'gambar'        => $gambarPath,
                'keterangan'    => $item['keterangan'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        $kategoriUnik = count(array_unique(array_column($items, 'nama_kategori')));
        $this->command->info('  ✓ Inventaris Peralatan: ' . count($items) . ' unit berhasil di-seed dalam ' . $kategoriUnik . ' kategori berbeda.');
    }
}

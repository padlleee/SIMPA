<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerpustakaanSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['judul' => 'Laskar Pelangi',                  'pengarang' => 'Andrea Hirata',       'penerbit' => 'Bentang Pustaka',   'tahun' => 2005, 'isbn' => '978-979-1227-00-3', 'kat' => 'Fiksi',              'jml' => 3, 'kondisi' => 'Baik'],
            ['judul' => 'Bumi Manusia',                     'pengarang' => 'Pramoedya Ananta Toer','penerbit' => 'Hasta Mitra',       'tahun' => 1980, 'isbn' => '978-979-444-900-0', 'kat' => 'Fiksi',              'jml' => 2, 'kondisi' => 'Cukup Baik'],
            ['judul' => 'Matematika SMP Kelas 7',           'pengarang' => 'Abdur Rahman As\'ari', 'penerbit' => 'Kemendikbud',       'tahun' => 2017, 'isbn' => '978-602-427-099-5', 'kat' => 'Pelajaran Sekolah',  'jml' => 5, 'kondisi' => 'Baik'],
            ['judul' => 'IPA Terpadu Kelas 8',              'pengarang' => 'Wahono Widodo',        'penerbit' => 'Kemendikbud',       'tahun' => 2017, 'isbn' => '978-602-427-110-7', 'kat' => 'Pelajaran Sekolah',  'jml' => 4, 'kondisi' => 'Baik'],
            ['judul' => 'Ensiklopedia Sains untuk Anak',    'pengarang' => 'Tim Redaksi',          'penerbit' => 'Erlangga',          'tahun' => 2018, 'isbn' => '978-602-298-800-1', 'kat' => 'Ensiklopedi',        'jml' => 2, 'kondisi' => 'Baik'],
            ['judul' => 'Kisah 25 Nabi dan Rasul',          'pengarang' => 'Achmad Lutfi',         'penerbit' => 'Amzah',             'tahun' => 2016, 'isbn' => '978-602-7949-50-1', 'kat' => 'Agama & Spiritual',  'jml' => 3, 'kondisi' => 'Baik'],
            ['judul' => 'Habis Gelap Terbitlah Terang',     'pengarang' => 'R.A. Kartini',         'penerbit' => 'Balai Pustaka',     'tahun' => 2004, 'isbn' => '978-979-407-048-5', 'kat' => 'Biografi',           'jml' => 2, 'kondisi' => 'Cukup Baik'],
            ['judul' => 'Soekarno: Bapak Indonesia',        'pengarang' => 'Reni Nuryanti',        'penerbit' => 'Ar-Ruzz Media',     'tahun' => 2010, 'isbn' => '978-979-769-360-2', 'kat' => 'Biografi',           'jml' => 1, 'kondisi' => 'Baik'],
            ['judul' => 'Sehat itu Mudah',                  'pengarang' => 'Phaidon Toruan',       'penerbit' => 'Hikmah',            'tahun' => 2013, 'isbn' => '978-602-7676-80-5', 'kat' => 'Kesehatan',          'jml' => 2, 'kondisi' => 'Baik'],
            ['judul' => 'Rahasia Meraih Impian',            'pengarang' => 'Mario Teguh',          'penerbit' => 'Esensi',            'tahun' => 2012, 'isbn' => '978-602-8488-73-2', 'kat' => 'Motivasi',           'jml' => 3, 'kondisi' => 'Baik'],
            ['judul' => 'Pemrograman Web dengan PHP',       'pengarang' => 'Betha Sidik',          'penerbit' => 'Informatika',       'tahun' => 2012, 'isbn' => '978-602-1180-36-0', 'kat' => 'Teknologi',          'jml' => 2, 'kondisi' => 'Cukup Baik'],
            ['judul' => 'Dunia Sophie',                     'pengarang' => 'Jostein Gaarder',      'penerbit' => 'Mizan',             'tahun' => 2000, 'isbn' => '978-979-433-370-3', 'kat' => 'Fiksi',              'jml' => 2, 'kondisi' => 'Rusak Ringan'],
            ['judul' => 'Ayat-Ayat Cinta',                  'pengarang' => 'Habiburrahman El Shirazy','penerbit'=>'Republika',        'tahun' => 2004, 'isbn' => '978-979-9105-85-8', 'kat' => 'Agama & Spiritual',  'jml' => 2, 'kondisi' => 'Baik'],
            ['judul' => 'Cerita Fabel Kancil dan Buaya',    'pengarang' => 'Penerbit Buku Desa',   'penerbit' => 'Pustaka Ceria',     'tahun' => 2019, 'isbn' => null,                'kat' => 'Anak-anak',          'jml' => 4, 'kondisi' => 'Baik'],
            ['judul' => 'Atlas Dunia Lengkap',              'pengarang' => 'Tim Kartografi',       'penerbit' => 'Gramedia',          'tahun' => 2020, 'isbn' => '978-602-06-4567-1', 'kat' => 'Ilmu Pengetahuan',   'jml' => 1, 'kondisi' => 'Baik'],
        ];

        foreach ($books as $idx => $book) {
            DB::table('perpustakaan')->insert([
                'kode_buku'    => 'BUK-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'judul_buku'   => $book['judul'],
                'pengarang'    => $book['pengarang'],
                'penulis'      => $book['pengarang'], // alias
                'penerbit'     => $book['penerbit'],
                'tahun_terbit' => $book['tahun'],
                'isbn'         => $book['isbn'],
                'kategori_buku'=> $book['kat'],
                'sinopsis'     => null,
                'foto_buku'    => null,
                'jumlah_buku'  => $book['jml'],
                'kondisi_buku' => $book['kondisi'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}

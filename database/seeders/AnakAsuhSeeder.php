<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnakAsuhSeeder extends Seeder
{
    public function run(): void
    {
        $namaAnak = [
            // Laki-laki
            ['nama' => 'Muhammad Rizki Pratama',    'jk' => 'L'],
            ['nama' => 'Fajar Nugroho',              'jk' => 'L'],
            ['nama' => 'Deni Kurniawan',             'jk' => 'L'],
            ['nama' => 'Arif Hidayat',               'jk' => 'L'],
            ['nama' => 'Bagas Dwi Saputra',          'jk' => 'L'],
            ['nama' => 'Rizal Maulana',              'jk' => 'L'],
            ['nama' => 'Eka Firmansyah',             'jk' => 'L'],
            ['nama' => 'Galih Pramono',              'jk' => 'L'],
            ['nama' => 'Hendra Wijaya',              'jk' => 'L'],
            ['nama' => 'Ivan Kurniadi',              'jk' => 'L'],
            // Perempuan
            ['nama' => 'Siti Nurhaliza',             'jk' => 'P'],
            ['nama' => 'Aulia Rahmawati',            'jk' => 'P'],
            ['nama' => 'Putri Andini',               'jk' => 'P'],
            ['nama' => 'Nadia Safitri',              'jk' => 'P'],
            ['nama' => 'Fitri Handayani',            'jk' => 'P'],
            ['nama' => 'Dinda Permatasari',          'jk' => 'P'],
            ['nama' => 'Rini Sulistiawati',          'jk' => 'P'],
            ['nama' => 'Yesi Oktaviani',             'jk' => 'P'],
            ['nama' => 'Lia Amelia',                 'jk' => 'P'],
            ['nama' => 'Sari Wulandari',             'jk' => 'P'],
        ];

        $kecamatanList = ['Subang', 'Jalancagak', 'Purwadadi', 'Cijambe', 'Kalijati', 'Pagaden'];
        $desaList      = ['Sukamaju', 'Cikarang', 'Margaasih', 'Neglasari', 'Mekarjaya', 'Sarireja'];

        // 15 Aktif, 5 Alumni
        $statuses = array_merge(array_fill(0, 15, 'Aktif'), array_fill(0, 5, 'Alumni'));

        $pendidikanMap = [
            'SD'  => ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6'],
            'SMP' => ['Kelas 7', 'Kelas 8', 'Kelas 9'],
            'SMA' => ['Kelas 10', 'Kelas 11', 'Kelas 12'],
        ];

        foreach ($namaAnak as $idx => $anak) {
            // Usia 6–18 tahun
            $usia          = rand(6, 18);
            $tglLahir      = Carbon::now()->subYears($usia)->subDays(rand(0, 365))->toDateString();
            $status        = $statuses[$idx];
            $tglMasuk      = Carbon::now()->subYears(rand(1, 4))->toDateString();

            // Tentukan pendidikan berdasarkan usia
            if ($usia <= 12) {
                $pendidikan = 'SD';
                $kelas      = 'Kelas ' . min(6, max(1, $usia - 6 + 1));
            } elseif ($usia <= 15) {
                $pendidikan = 'SMP';
                $kelas      = 'Kelas ' . ($usia - 12 + 7);
            } else {
                $pendidikan = 'SMA';
                $kelas      = 'Kelas ' . min(12, $usia - 15 + 10);
            }

            DB::table('anak_asuh')->insert([
                'nama_anak'             => $anak['nama'],
                'tempat_lahir'          => $kecamatanList[array_rand($kecamatanList)],
                'tanggal_lahir'         => $tglLahir,
                'jenis_kelamin'         => $anak['jk'],
                'pendidikan'            => $pendidikan,
                'kelas'                 => $kelas,
                'jenis_layanan'         => 'Panti Asuhan',
                'dusun'                 => 'Dusun ' . chr(rand(65, 70)),
                'rt'                    => sprintf('%03d', rand(1, 10)),
                'rw'                    => sprintf('%03d', rand(1, 5)),
                'desa'                  => $desaList[array_rand($desaList)],
                'kecamatan'             => $kecamatanList[array_rand($kecamatanList)],
                'status_anak'           => $status,
                'tanggal_masuk'         => $tglMasuk,
                'catatan_kesehatan'     => $status === 'Aktif' ? fake()->randomElement(['Sehat', 'Sehat, perlu kontrol rutin', 'Sehat dan aktif']) : null,
                'perkembangan_akademik' => fake()->randomElement(['Baik', 'Sangat Baik', 'Perlu perhatian khusus', 'Meningkat pesat']),
                'created_at'            => now(),
            ]);
        }
    }
}

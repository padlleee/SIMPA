<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Donatur;
use App\Models\User;
use Carbon\Carbon;

class DonasiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua donatur terdaftar
        $donaturList = Donatur::with('user')->get();
        // Ambil admin/bendahara untuk verifikasi
        $bendahara   = User::where('role', 'Bendahara')->first();

        // Nama & email donatur publik (anonim)
        $donaturPublik = [
            ['nama' => 'Hamba Allah',         'email' => null],
            ['nama' => 'Anonim',              'email' => null],
            ['nama' => 'Keluarga Besar Haji Soleh', 'email' => 'hajsoleh@gmail.com'],
            ['nama' => 'PT Berkah Abadi',     'email' => 'csr@berkah-abadi.co.id'],
            ['nama' => 'Masjid Al-Ikhlas',    'email' => 'masjid.alikhlas@gmail.com'],
            ['nama' => 'Ibu Yayuk Supriatna', 'email' => 'yayuk.sup@gmail.com'],
            ['nama' => 'Donatur Tidak Dikenal', 'email' => null],
            ['nama' => 'Komunitas Peduli Yatim', 'email' => 'kpy.subang@gmail.com'],
            ['nama' => 'Bapak H. Asep Rahman', 'email' => 'asep.rahman@yahoo.com'],
            ['nama' => 'Koperasi Maju Bersama', 'email' => 'koperasi.mb@gmail.com'],
        ];

        // Status distribution: 12 Valid, 5 Pending, 3 Tolak
        $statuses = [
            ...array_fill(0, 12, 'Valid'),
            ...array_fill(0, 5,  'Pending'),
            ...array_fill(0, 3,  'Tolak'),
        ];
        shuffle($statuses);

        $metode  = ['Transfer', 'QRIS', 'Tunai', 'BJB', 'BRI'];

        // Nominal bervariasi dari 50.000 hingga 50.000.000
        $nominals = [
            50000, 75000, 100000, 150000, 200000,
            250000, 500000, 750000, 1000000, 1500000,
            2000000, 2500000, 5000000, 7500000, 10000000,
            15000000, 20000000, 25000000, 35000000, 50000000,
        ];
        shuffle($nominals);

        $records = [];

        // 10 donasi dari donatur terdaftar
        foreach ($donaturList->take(10) as $idx => $donatur) {
            $status     = $statuses[$idx];
            $tglDonasi  = Carbon::now()->subDays(rand(1, 180));

            $records[] = [
                'id_donatur'           => $donatur->id_user, // FK ke users.id_user
                'nama_donatur_manual'  => null,
                'email_donatur_manual' => null,
                'nominal'              => $nominals[$idx],
                'metode_pembayaran'    => $metode[array_rand($metode)],
                'bukti_pembayaran'     => null,
                'status_verifikasi'    => $status,
                'id_bendahara'         => in_array($status, ['Valid', 'Tolak']) ? $bendahara?->id_user : null,
                'catatan_verifikasi'   => $status === 'Valid' ? 'Transfer dikonfirmasi.' : ($status === 'Tolak' ? 'Bukti transfer tidak valid.' : null),
                'tanggal_donasi'       => $tglDonasi,
                'tanggal_verifikasi'   => in_array($status, ['Valid', 'Tolak']) ? $tglDonasi->addDays(rand(1, 3)) : null,
            ];
        }

        // 10 donasi publik (anonim)
        foreach ($donaturPublik as $idx => $pub) {
            $statusIdx  = 10 + $idx;
            $status     = $statuses[$statusIdx] ?? 'Pending';
            $tglDonasi  = Carbon::now()->subDays(rand(1, 120));

            $records[] = [
                'id_donatur'           => null,
                'nama_donatur_manual'  => $pub['nama'],
                'email_donatur_manual' => $pub['email'],
                'nominal'              => $nominals[10 + $idx],
                'metode_pembayaran'    => $metode[array_rand($metode)],
                'bukti_pembayaran'     => null,
                'status_verifikasi'    => $status,
                'id_bendahara'         => in_array($status, ['Valid', 'Tolak']) ? $bendahara?->id_user : null,
                'catatan_verifikasi'   => $status === 'Valid' ? 'Donasi publik diterima.' : ($status === 'Tolak' ? 'Data tidak lengkap.' : null),
                'tanggal_donasi'       => $tglDonasi,
                'tanggal_verifikasi'   => in_array($status, ['Valid', 'Tolak']) ? $tglDonasi->copy()->addDays(rand(1, 3)) : null,
            ];
        }

        DB::table('donasi')->insert($records);
    }
}

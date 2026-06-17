<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengurusNonAktif;
use App\Models\AnakAsuh;
use Carbon\Carbon;

class OldDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed Old Pengurus
        $oldPengurus = ['Tarmidi', 'Apandi', 'Sukardi'];
        foreach ($oldPengurus as $nama) {
            PengurusNonAktif::firstOrCreate(['nama' => $nama], [
                'nama' => $nama,
                'jabatan_terakhir' => null,
                'tahun_nonaktif' => '2020' // From the text "sejak Oktober 2020"
            ]);
        }

        // 2. Seed Old Alumni
        $oldAlumni = [
            'Casmadi', 'Karim', 'Neng Kasih', 'Agil London Fauzan', 'Selvia Dewi', 
            'Priatna', 'Cica Amalia', 'Rizky Ramadhani', 'Dede Roza', 'Neng Siska Agustiani', 
            'Muhamad Iman Muttaqin', 'Anjar', 'Asep', 'Samsul M', 'Syafiq', 'Dana', 
            'Handoko', 'Gita Diana', 'Sinta', 'Ainun', 'Rega', 'Yeni', 'Nova'
        ];

        foreach ($oldAlumni as $nama) {
            AnakAsuh::firstOrCreate(['nama_anak' => $nama], [
                'nama_anak' => $nama,
                'tempat_lahir' => 'Subang', // Default dummy
                'tanggal_lahir' => Carbon::now()->subYears(20), // Default dummy
                'jenis_kelamin' => 'L', // Default dummy, can be edited later
                'pendidikan' => 'Lulus',
                'status_anak' => 'Alumni',
                'tanggal_masuk' => Carbon::now()->subYears(10), // Default dummy
            ]);
        }
    }
}

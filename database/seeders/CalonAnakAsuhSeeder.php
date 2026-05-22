<?php

namespace Database\Seeders;

use App\Models\CalonAnakAsuh;
use App\Models\User;
use Illuminate\Database\Seeder;

class CalonAnakAsuhSeeder extends Seeder
{
    public function run(): void
    {
        $admin     = User::where('role', 'Admin')->first();
        $ketua     = User::where('role', 'Ketua')->first();
        $reviewer  = $admin ?? $ketua;

        $registrations = [
            // ── Pending (belum ditinjau) ──────────────────────────────────
            [
                'nama_anak'      => 'Muhammad Rizki Pratama',
                'tanggal_lahir'  => '2014-03-15',
                'jenis_kelamin'  => 'Laki-laki',
                'nama_wali'      => 'Asep Supriatna',
                'kontak_wali'    => '085712345678',
                'alasan_masuk'   => 'Ayah telah meninggal dunia pada tahun 2023 akibat kecelakaan kerja. Ibu bekerja sebagai buruh cuci dengan penghasilan tidak menentu dan tidak mampu menanggung biaya sekolah dan kehidupan sehari-hari anak.',
                'dokumen_path'   => null,
                'status'         => 'Pending',
                'reviewed_by'    => null,
                'reviewed_at'    => null,
                'catatan_review' => null,
            ],
            [
                'nama_anak'      => 'Siti Aisyah Ramadhani',
                'tanggal_lahir'  => '2013-07-22',
                'jenis_kelamin'  => 'Perempuan',
                'nama_wali'      => 'Neneng Suryani',
                'kontak_wali'    => '082198765432',
                'alasan_masuk'   => 'Kedua orang tua anak telah bercerai. Ibu kandung tidak diketahui keberadaannya, dan ayah kandung telah menikah lagi dengan istri baru yang tidak menerima keberadaan anak. Saat ini anak tinggal bersama nenek yang sudah berusia lanjut dan tidak mampu secara ekonomi.',
                'dokumen_path'   => null,
                'status'         => 'Pending',
                'reviewed_by'    => null,
                'reviewed_at'    => null,
                'catatan_review' => null,
            ],
            [
                'nama_anak'      => 'Dian Permana',
                'tanggal_lahir'  => '2015-11-08',
                'jenis_kelamin'  => 'Laki-laki',
                'nama_wali'      => 'Andi Firmansyah',
                'kontak_wali'    => '087834567890',
                'alasan_masuk'   => 'Ibu kandung meninggal dunia saat melahirkan adik ketiga. Ayah seorang petani dengan penghasilan yang hanya cukup untuk makan sehari-hari. Ayah memohon bantuan yayasan untuk menitipkan anak agar dapat mengenyam pendidikan yang lebih baik.',
                'dokumen_path'   => null,
                'status'         => 'Pending',
                'reviewed_by'    => null,
                'reviewed_at'    => null,
                'catatan_review' => null,
            ],

            // ── Disetujui ────────────────────────────────────────────────
            [
                'nama_anak'      => 'Rina Kurniawati',
                'tanggal_lahir'  => '2012-05-18',
                'jenis_kelamin'  => 'Perempuan',
                'nama_wali'      => 'Tuti Alawiyah',
                'kontak_wali'    => '081356789012',
                'alasan_masuk'   => 'Yatim piatu sejak usia 4 tahun. Kedua orang tua meninggal dalam musibah banjir bandang. Saat ini diasuh oleh bibi yang juga memiliki 5 orang anak dengan kondisi ekonomi sangat terbatas. Bibi tidak sanggup membiayai sekolah anak ke jenjang SMP.',
                'dokumen_path'   => null,
                'status'         => 'Disetujui',
                'reviewed_by'    => $reviewer?->id_user,
                'reviewed_at'    => now()->subDays(15),
                'catatan_review' => null,
            ],
            [
                'nama_anak'      => 'Ahmad Fajar Nugroho',
                'tanggal_lahir'  => '2011-09-02',
                'jenis_kelamin'  => 'Laki-laki',
                'nama_wali'      => 'Budi Raharjo',
                'kontak_wali'    => '089012345678',
                'alasan_masuk'   => 'Yatim, ayah meninggal akibat penyakit liver kronis. Ibu menderita sakit komplikasi dan memerlukan perawatan intensif sehingga tidak dapat bekerja. Paman (Budi Raharjo) mengajukan pendaftaran setelah berkonsultasi dengan Dinas Sosial setempat.',
                'dokumen_path'   => null,
                'status'         => 'Disetujui',
                'reviewed_by'    => $reviewer?->id_user,
                'reviewed_at'    => now()->subDays(30),
                'catatan_review' => null,
            ],

            // ── Ditolak ──────────────────────────────────────────────────
            [
                'nama_anak'      => 'Bagas Wicaksono',
                'tanggal_lahir'  => '2010-04-25',
                'jenis_kelamin'  => 'Laki-laki',
                'nama_wali'      => 'Hendra Setiawan',
                'kontak_wali'    => '081223344556',
                'alasan_masuk'   => 'Orang tua bercerai, ayah bekerja di luar kota. Penghasilan ayah masih ada namun tidak teratur. Anak ingin masuk panti karena sering konflik dengan ibu tiri.',
                'dokumen_path'   => null,
                'status'         => 'Ditolak',
                'reviewed_by'    => $reviewer?->id_user,
                'reviewed_at'    => now()->subDays(7),
                'catatan_review' => 'Berdasarkan hasil verifikasi, kondisi ekonomi keluarga masih tergolong mampu. Ayah kandung masih hidup dan bekerja. Disarankan untuk koordinasi dengan Dinas Sosial dan konseling keluarga terlebih dahulu sebelum mengajukan kembali.',
            ],
        ];

        foreach ($registrations as $data) {
            CalonAnakAsuh::updateOrCreate(
                [
                    'nama_anak'     => $data['nama_anak'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                ],
                $data
            );
        }
    }
}

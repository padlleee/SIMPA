<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faqs = [
            // Kategori: Profil
            [
                'kategori' => 'profil',
                'pertanyaan' => 'Apakah Yayasan Panti Asuhan Amaliya adalah lembaga resmi dan terdaftar?',
                'jawaban' => 'Ya. Yayasan Panti Asuhan Amaliya adalah lembaga resmi yang terdaftar di Kementerian Hukum dan Hak Asasi Manusia Republik Indonesia serta telah memiliki izin operasional dari Dinas Sosial Kabupaten Subang. Semua legalitas dapat dikonfirmasi langsung kepada pengurus yayasan.',
                'urutan' => 1
            ],
            [
                'kategori' => 'profil',
                'pertanyaan' => 'Di mana lokasi Yayasan Panti Asuhan Amaliya?',
                'jawaban' => 'Yayasan kami berlokasi di Blok Suka Asih I RT. 64/18, Kelurahan Karanganyar, Kecamatan Subang, Kabupaten Subang, Jawa Barat 41211, Indonesia. Anda dapat menemukan lokasi kami di Google Maps dengan koordinat -6.570183, 107.757358.',
                'urutan' => 2
            ],
            [
                'kategori' => 'profil',
                'pertanyaan' => 'Berapa jumlah anak asuh yang saat ini tinggal di panti?',
                'jawaban' => 'Saat ini kami menampung lebih dari 50 anak asuh aktif, dengan rentang usia mulai dari 6 hingga 18 tahun. Selain itu, kami memiliki lebih dari 120 alumni yang telah berhasil mandiri dan melanjutkan pendidikan maupun karir mereka.',
                'urutan' => 3
            ],
            [
                'kategori' => 'profil',
                'pertanyaan' => 'Bagaimana sistem pengelolaan keuangan yayasan dijaga transparansinya?',
                'jawaban' => 'Kami menggunakan sistem SIMPA (Sistem Informasi Manajemen Panti Asuhan) yang memungkinkan pencatatan setiap transaksi donasi secara real-time dan dapat diverifikasi. Setiap donasi yang masuk akan dikonfirmasi oleh pengurus dan donatur dapat mengunduh kwitansi resmi digital.',
                'urutan' => 4
            ],
            [
                'kategori' => 'profil',
                'pertanyaan' => 'Apakah yayasan ini berafiliasi dengan partai politik atau organisasi tertentu?',
                'jawaban' => 'Tidak. Yayasan Panti Asuhan Amaliya adalah lembaga sosial yang bersifat independen, tidak berafiliasi dengan partai politik, kelompok kepentingan, atau organisasi komersial manapun. Kami berfokus sepenuhnya pada misi kemanusiaan dan pendidikan.',
                'urutan' => 5
            ],

            // Kategori: Donasi
            [
                'kategori' => 'donasi',
                'pertanyaan' => 'Apa saja bentuk donasi yang bisa saya berikan?',
                'jawaban' => 'Kami menerima donasi dalam berbagai bentuk: (1) Donasi Uang Tunai — melalui transfer bank atau datang langsung ke yayasan, (2) Donasi Barang — seperti sembako, pakaian layak pakai, peralatan sekolah, buku, dan perlengkapan ibadah, (3) Sponsorship Beasiswa — untuk membiayai pendidikan seorang anak asuh, (4) Donasi Non-Material — seperti keahlian atau waktu sebagai relawan.',
                'urutan' => 1
            ],
            [
                'kategori' => 'donasi',
                'pertanyaan' => 'Bagaimana cara berdonasi secara online tanpa mendaftar akun?',
                'jawaban' => 'Sangat mudah! Kunjungi halaman Form Donasi Publik yang tersedia di website ini. Isi formulir dengan nama, kontak, jumlah donasi, dan unggah bukti transfer Anda. Tim kami akan memverifikasi dalam 1x24 jam dan Anda akan mendapatkan kwitansi digital resmi.',
                'urutan' => 2
            ],
            [
                'kategori' => 'donasi',
                'pertanyaan' => 'Ke rekening mana saya bisa mentransfer donasi?',
                'jawaban' => 'Informasi rekening resmi yayasan akan tercantum di halaman konfirmasi setelah Anda mengisi formulir donasi. Pastikan selalu menggunakan formulir resmi di website ini untuk menghindari penipuan. Jika ragu, konfirmasi langsung ke kontak resmi kami di +62 811-9918-090.',
                'urutan' => 3
            ],
            [
                'kategori' => 'donasi',
                'pertanyaan' => 'Apakah donasi saya dijamin sampai ke penerima yang tepat?',
                'jawaban' => 'Ya. Setiap donasi yang masuk dicatat secara digital di sistem SIMPA kami dan hanya dapat digunakan setelah melalui proses verifikasi oleh admin. Laporan penggunaan dana disusun secara berkala dan dapat diminta oleh donatur terdaftar. Transparansi adalah komitmen utama kami.',
                'urutan' => 4
            ],
            [
                'kategori' => 'donasi',
                'pertanyaan' => 'Apakah ada nominal minimum untuk berdonasi?',
                'jawaban' => 'Tidak ada nominal minimum. Kami menerima donasi berapapun besarannya karena setiap kontribusi, sekecil apapun, memiliki arti yang sangat besar bagi anak-anak asuh kami.',
                'urutan' => 5
            ],
            [
                'kategori' => 'donasi',
                'pertanyaan' => 'Bagaimana dengan donasi barang? Apakah bisa diantarkan atau harus langsung ke panti?',
                'jawaban' => 'Donasi barang bisa dilakukan dengan dua cara: (1) Mengantar langsung ke alamat yayasan selama jam operasional (08.00–17.00 WIB), atau (2) Menghubungi kami terlebih dahulu untuk mengatur jadwal pengambilan jika Anda berada di wilayah Subang dan sekitarnya.',
                'urutan' => 6
            ],

            // Kategori: Akun (Keanggotaan)
            [
                'kategori' => 'akun',
                'pertanyaan' => 'Apa keuntungan mendaftar sebagai Donatur Tetap (memiliki akun)?',
                'jawaban' => 'Donatur yang memiliki akun terdaftar di sistem SIMPA akan mendapatkan: (1) Dashboard pribadi untuk melihat riwayat seluruh donasi yang pernah diberikan, (2) Akses mudah ke formulir donasi dengan data yang sudah terisi otomatis, (3) Kwitansi digital resmi untuk setiap transaksi, (4) Notifikasi perkembangan terbaru dari yayasan, (5) Akses ke laporan tahunan penggunaan dana yayasan.',
                'urutan' => 1
            ],
            [
                'kategori' => 'akun',
                'pertanyaan' => 'Bagaimana cara mendaftar sebagai Donatur dengan akun?',
                'jawaban' => 'Klik tombol "Daftar sebagai Donatur" di halaman utama atau kunjungi halaman Permintaan Akun. Isi formulir pendaftaran dengan data diri yang valid. Pengurus akan memverifikasi pengajuan Anda dalam 1-2 hari kerja. Setelah disetujui, Anda akan mendapatkan kredensial login melalui email.',
                'urutan' => 2
            ],
            [
                'kategori' => 'akun',
                'pertanyaan' => 'Apakah saya bisa berdonasi tanpa mendaftar akun?',
                'jawaban' => 'Tentu! Donasi tanpa akun (sebagai tamu/publik) sepenuhnya tersedia dan tidak memerlukan pendaftaran apapun. Akun hanya diperlukan jika Anda ingin memiliki dashboard pribadi dan riwayat donasi yang tersimpan secara permanen.',
                'urutan' => 3
            ],
            [
                'kategori' => 'akun',
                'pertanyaan' => 'Apakah data pribadi saya aman di sistem SIMPA?',
                'jawaban' => 'Data pribadi Anda dijaga dengan ketat. Sistem SIMPA menggunakan enkripsi standar industri untuk melindungi kata sandi dan informasi sensitif Anda. Data Anda tidak akan pernah dijual, disewakan, atau dibagikan kepada pihak ketiga tanpa persetujuan Anda.',
                'urutan' => 4
            ],
            [
                'kategori' => 'akun',
                'pertanyaan' => 'Bagaimana cara mengubah kata sandi akun saya?',
                'jawaban' => 'Setelah login, Anda dapat mengakses menu "Pengaturan Akun" dari dropdown profil di pojok kanan atas halaman. Di sana tersedia fitur untuk mengubah kata sandi Anda kapan saja. Jika lupa kata sandi, hubungi admin yayasan melalui email untuk reset.',
                'urutan' => 5
            ],

            // Kategori: Layanan (Relawan)
            [
                'kategori' => 'layanan',
                'pertanyaan' => 'Siapa saja yang bisa menjadi relawan di Yayasan Amaliya?',
                'jawaban' => 'Siapa saja yang memiliki niat tulus untuk berbagi! Kami terbuka bagi mahasiswa, profesional, pensiunan, atau siapapun yang ingin berkontribusi. Untuk relawan pengajar, kami membutuhkan komitmen minimal 2 jam per minggu dan memiliki kemampuan di bidang yang akan diajarkan (misalnya matematika, bahasa Inggris, komputer, kesenian, dll).',
                'urutan' => 1
            ],
            [
                'kategori' => 'layanan',
                'pertanyaan' => 'Bagaimana cara mendaftar sebagai relawan?',
                'jawaban' => 'Untuk mendaftar sebagai relawan: (1) Hubungi kami melalui email di info.amaliyasubang@gmail.com atau telepon +62 811-9918-090, (2) Sampaikan bidang keahlian dan hari/waktu yang tersedia, (3) Tim kami akan menghubungi Anda untuk proses orientasi singkat sebelum mulai bertugas.',
                'urutan' => 2
            ],
            [
                'kategori' => 'layanan',
                'pertanyaan' => 'Apa itu Program Sponsorship Beasiswa dan bagaimana cara mengikutinya?',
                'jawaban' => 'Program Sponsorship Beasiswa adalah program di mana Anda secara khusus menanggung biaya pendidikan satu anak asuh (biaya sekolah, seragam, alat tulis, buku). Sponsor dapat memilih jenjang pendidikan yang ingin dibantu (SD/SMP/SMA) dan akan mendapatkan laporan perkembangan anak yang disponsori secara berkala. Hubungi admin kami untuk informasi lebih lanjut.',
                'urutan' => 3
            ],
            [
                'kategori' => 'layanan',
                'pertanyaan' => 'Apakah ada pendaftaran anak asuh baru? Bagaimana prosedurnya?',
                'jawaban' => 'Ya, kami membuka pendaftaran anak asuh baru dengan kapasitas terbatas. Persyaratan umum meliputi: anak usia 6-15 tahun, yatim/piatu atau dari keluarga kurang mampu, memiliki surat keterangan dari kelurahan/desa, dan surat persetujuan dari wali. Untuk formulir pendaftaran, kunjungi halaman "Daftar Anak Asuh" di website ini atau datang langsung ke yayasan.',
                'urutan' => 4
            ],
            [
                'kategori' => 'layanan',
                'pertanyaan' => 'Apakah yayasan menerima kunjungan atau studi banding dari luar?',
                'jawaban' => 'Ya, kami terbuka untuk kunjungan tamu, studi banding dari sekolah/universitas, atau liputan media. Kunjungan harus dijadwalkan terlebih dahulu minimal 3 hari kerja sebelumnya dengan menghubungi admin yayasan. Hal ini untuk memastikan kenyamanan anak-anak asuh dan kelancaran kegiatan sehari-hari.',
                'urutan' => 5
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}

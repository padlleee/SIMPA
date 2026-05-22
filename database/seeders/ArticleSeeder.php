<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil satu user Admin/Ketua untuk dijadikan author
        $admin = User::where('role', 'Admin')->first();

        $articles = [
            [
                'title'   => 'Program Pembuatan Film Pendek Bersama Anak Asuh',
                'content' => "Sebagai bagian dari program pengembangan bakat, anak-anak asuh Yayasan Amaliya berkesempatan mengikuti workshop pembuatan film pendek yang difasilitasi oleh komunitas sinema lokal Subang.\n\nKegiatan yang berlangsung selama tiga hari ini bertujuan untuk mengenalkan dunia perfilman secara sederhana—mulai dari penulisan naskah, pengambilan gambar menggunakan kamera smartphone, hingga proses editing dasar.\n\nAnak-anak terlihat antusias dan penuh semangat. Beberapa di antaranya berhasil menyelesaikan film berdurasi 2–3 menit yang mengangkat tema persahabatan dan cita-cita. Karya mereka kemudian ditayangkan dalam acara nonton bareng sederhana di aula yayasan.\n\nProgram ini diharapkan dapat menumbuhkan kreativitas dan kepercayaan diri anak-anak dalam mengekspresikan diri melalui media visual.",
                'image'   => 'blog/film.png',
            ],
            [
                'title'   => 'Renovasi Ruang Belajar: Wajah Baru untuk Semangat Baru',
                'content' => "Alhamdulillah, setelah beberapa bulan dalam perencanaan, renovasi ruang belajar utama Yayasan Amaliya akhirnya rampung dikerjakan pada pertengahan bulan ini.\n\nDengan dukungan dari para donatur yang setia, ruang belajar yang sebelumnya terasa sempit dan kurang pencahayaan kini tampil lebih terang, rapi, dan nyaman. Dinding dicat ulang, meja dan kursi belajar diganti yang baru, dan instalasi kipas angin ditambahkan untuk kenyamanan saat cuaca panas.\n\nKepala yayasan menyampaikan rasa terima kasih yang tulus kepada seluruh donatur yang telah mewujudkan impian ini. 'Anak-anak kita berhak mendapatkan tempat belajar yang layak dan menyenangkan,' ujar beliau dalam sambutan peresmian ruang belajar baru tersebut.\n\nDengan fasilitas yang lebih baik, kami berharap semangat belajar anak-anak asuh akan semakin meningkat.",
                'image'   => 'blog/renovasi.png',
            ],
            [
                'title'   => 'Kegiatan Studi Rutin: Belajar Iqra dan Tahfidz Setiap Sore',
                'content' => "Setiap sore hari setelah waktu Ashar, suasana yayasan dipenuhi dengan lantunan ayat-ayat Al-Qur'an. Ini adalah kegiatan studi rutin yang sudah menjadi tradisi di Yayasan Amaliya sejak berdirinya lembaga ini.\n\nDipandu oleh ustadz dan ustadzah yang berdedikasi, anak-anak belajar membaca Iqra mulai dari tingkat dasar, hingga yang sudah lebih mahir mulai menghafal surat-surat pendek dalam program tahfidz.\n\nProgram ini tidak hanya bertujuan untuk membentuk hafalan, tetapi juga membangun karakter dan kedisiplinan spiritual anak-anak asuh. Orang tua wali yang sesekali berkunjung pun mengaku bangga melihat perkembangan anak-anak mereka.\n\nHingga saat ini, tercatat beberapa anak asuh telah mampu menghafal Juz 30 dengan baik dan lancar.",
                'image'   => 'blog/iqra.png',
            ],
            [
                'title'   => 'Kunjungan Donatur Korporat: Sinergi untuk Masa Depan Anak Asuh',
                'content' => "Yayasan Amaliya menerima kunjungan dari tim CSR salah satu perusahaan swasta yang bergerak di sektor manufaktur di Subang. Kunjungan ini merupakan tindak lanjut dari komunikasi yang telah terjalin dalam beberapa bulan terakhir.\n\nDalam kunjungan tersebut, tim CSR berkesempatan berinteraksi langsung dengan anak-anak asuh, melihat fasilitas yayasan, serta mendengar pemaparan program dari pengurus yayasan.\n\nSebagai hasil dari pertemuan ini, perusahaan menyatakan komitmen untuk memberikan dukungan berupa paket sembako bulanan selama enam bulan ke depan, serta beasiswa pendidikan untuk dua anak asuh yang akan melanjutkan ke jenjang SMA.\n\nKami berterima kasih atas kepercayaan dan dukungan yang diberikan. Semoga kerja sama ini dapat terus berlanjut dan memberikan manfaat nyata bagi anak-anak asuh kami.",
                'image'   => 'blog/kunjungan.png',
            ],
            [
                'title'   => 'Pelatihan Keterampilan Menjahit untuk Anak Asuh Perempuan',
                'content' => "Dalam rangka membekali anak-anak asuh dengan keterampilan praktis yang berguna di masa depan, yayasan menyelenggarakan pelatihan dasar menjahit yang dikhususkan untuk anak asuh perempuan usia 14 tahun ke atas.\n\nPelatihan ini berlangsung selama dua minggu dengan menghadirkan instruktur berpengalaman dari komunitas pengrajin setempat. Peserta diajarkan mulai dari penggunaan mesin jahit, membaca pola, hingga menjahit produk sederhana seperti sarung bantal dan taplak meja.\n\nDi akhir pelatihan, setiap peserta berhasil menyelesaikan satu produk karya sendiri yang kemudian dipamerkan dalam pameran kecil di aula yayasan. Beberapa karya bahkan mendapat peminat dari pengunjung yang hadir.\n\nKami berharap keterampilan ini dapat menjadi bekal berharga bagi mereka saat nanti terjun ke masyarakat.",
                'image'   => 'blog/menjahit.png',
            ],
            [
                'title'   => 'Perayaan Hari Kemerdekaan: Semangat 17 Agustus di Yayasan Amaliya',
                'content' => "Suasana meriah menyelimuti Yayasan Amaliya Subang dalam rangka memperingati Hari Ulang Tahun Kemerdekaan Republik Indonesia yang ke-79.\n\nBerbagai lomba tradisional digelar untuk memeriahkan hari bersejarah ini, mulai dari balap karung, makan kerupuk, tarik tambang, hingga lomba menggambar bertema kemerdekaan. Tidak hanya anak asuh yang berpartisipasi, para pengurus dan donatur yang hadir pun turut serta dalam kegembiraan.\n\nAcara puncak diisi dengan upacara pengibaran bendera merah putih yang dipimpin oleh ketua yayasan, diikuti oleh seluruh anak asuh dan pengurus dengan penuh khidmat.\n\nMomen ini sekaligus menjadi pengingat bagi kita semua bahwa kemerdekaan sejati adalah ketika setiap anak bangsa mendapat kesempatan yang setara untuk tumbuh, belajar, dan meraih cita-cita.",
                'image'   => 'blog/kemerdekaan.png',
            ],
        ];

        foreach ($articles as $data) {
            $slug = Str::slug($data['title']) . '-' . Str::random(5);

            Article::updateOrCreate(
                ['title' => $data['title']],
                [
                    'slug'     => $slug,
                    'content'  => $data['content'],
                    'image'    => $data['image'],
                    'id_admin' => $admin?->id_user,
                ]
            );
        }
    }
}

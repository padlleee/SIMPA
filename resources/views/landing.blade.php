<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPA – Panti Asuhan Amaliya</title>
    <meta name="description" content="Sistem Informasi Manajemen Panti Asuhan Amaliya – transparansi donasi dan pengelolaan panti.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* BACKGROUND CROSSFADE ANIMATION */
        .hero-background {
            position: relative;
            overflow: hidden;
        }

        .bg-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            animation: crossfade 10s ease-in-out infinite;
        }

        .bg-slide:nth-child(1) {
            background-image: url('/images/land1.jpg');
            animation-delay: 0s;
        }

        .bg-slide:nth-child(2) {
            background-image: url('/images/land2.jpg');
            animation-delay: 5s;
        }

        @keyframes crossfade {
            0%   { opacity: 0.35; }
            50%  { opacity: 0.35; }
            100% { opacity: 0.35; }
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(51, 65, 85, 0.8) 50%, rgba(71, 85, 105, 0.8) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.15); }
        .nav-link { transition: color 0.15s ease; }

        /* PROGRESS BAR ANIMATION */
        .progress-fill {
            transition: width 1s ease-out;
        }

        .counter {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body class="bg-white text-slate-800">

<!-- NAVBAR -->
<nav class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="text-xl font-bold text-slate-800">SIMPA</span>
        </div>
        <div class="hidden md:flex items-center gap-8">
            <a href="#program" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Program</a>
            <a href="{{ route('perpustakaan.public.index') }}" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Perpustakaan</a>
            <a href="#donasi-progress" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Donasi</a>
            <button onclick="openLoginModal()" class="bg-slate-800 text-white px-5 py-2 rounded-lg hover:bg-slate-700 font-medium transition-colors">Masuk</button>
        </div>
    </div>
</nav>

<!-- HERO with Dynamic Background -->
<section class="hero-background min-h-screen flex items-center pt-20 relative">
    <div class="bg-slide"></div>
    <div class="bg-slide"></div>
    <div class="bg-overlay"></div>

    <div class="hero-content max-w-6xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <span class="inline-block bg-white/10 text-white/90 text-sm font-medium px-4 py-1.5 rounded-full mb-6">Yayasan Amaliya Subang</span>
            <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight mb-6">
                Bersama Kita<br>
                <span class="text-slate-300">Tumbuhkan Harapan</span>
            </h1>
            <p class="text-slate-300 text-lg leading-relaxed mb-10">
                SIMPA hadir untuk mengelola yayasan panti asuhan secara transparan dan profesional. Setiap donasi Anda langsung tercatat dan terverifikasi.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('donasi.index') }}" class="bg-white text-slate-800 px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-100 transition-colors">
                    Donasi Sekarang
                </a>
                <a href="#program" class="border border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white/10 transition-colors">
                    Lihat Program
                </a>
            </div>
        </div>
        <!-- Stats Card -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
            <h3 class="text-white font-semibold text-lg mb-6">Dampak Nyata Kami</h3>
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white/10 rounded-xl p-5">
                    <div class="text-4xl font-bold text-white">50+</div>
                    <div class="text-slate-300 text-sm mt-1">Anak Asuh Aktif</div>
                </div>
                <div class="bg-white/10 rounded-xl p-5">
                    <div class="text-4xl font-bold text-white">120+</div>
                    <div class="text-slate-300 text-sm mt-1">Alumni Berhasil</div>
                </div>
                <div class="bg-white/10 rounded-xl p-5">
                    <div class="text-4xl font-bold text-white">10+</div>
                    <div class="text-slate-300 text-sm mt-1">Tahun Berkarya</div>
                </div>
                <div class="bg-white/10 rounded-xl p-5">
                    <div class="text-4xl font-bold text-white">500+</div>
                    <div class="text-slate-300 text-sm mt-1">Donatur Setia</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DONATION PROGRESS BAR -->
<section id="donasi-progress" class="py-16 bg-gradient-to-r from-slate-50 to-slate-100">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-slate-800 mb-3">Target Donasi Kami</h2>
            <p class="text-slate-600">Setiap donasi Anda membantu kami memberikan yang terbaik untuk anak-anak asuh.</p>
        </div>

        @php
            $donasiController = new \App\Http\Controllers\DonasiController();
            $stats = $donasiController->getPublicStats();
        @endphp

        <div class="bg-white rounded-2xl p-8 shadow-lg border border-slate-200">
            <div class="mb-6">
                <div class="flex justify-between items-end mb-3">
                    <div>
                        <p class="text-slate-600 font-medium mb-1">Terkumpul</p>
                        <p class="text-3xl font-bold text-slate-800 counter">Rp {{ number_format($stats['totalVerified'], 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-600 font-medium mb-1">Target</p>
                        <p class="text-lg font-semibold text-slate-700">Rp {{ number_format($stats['donationGoal'], 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full h-4 bg-slate-200 rounded-full overflow-hidden">
                    <div class="progress-fill h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full" style="width: {{ $stats['percentage'] }}%;"></div>
                </div>

                <div class="flex justify-between items-center mt-3">
                    <p class="text-slate-600 text-sm">{{ $stats['percentage'] }}% terkumpul</p>
                    <p class="text-slate-600 text-sm">Rp {{ number_format($stats['donationGoal'] - $stats['totalVerified'], 0, ',', '.') }} lagi</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 pt-6 border-t border-slate-200">
                <div class="text-center">
                    <p class="text-slate-600 text-sm font-medium">Program Pendidikan</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">30%</p>
                </div>
                <div class="text-center">
                    <p class="text-slate-600 text-sm font-medium">Kesehatan & Gizi</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">50%</p>
                </div>
                <div class="text-center">
                    <p class="text-slate-600 text-sm font-medium">Operasional</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">20%</p>
                </div>
            </div>

            <p class="text-center text-slate-600 text-sm mt-6">Alokasi dana untuk tiga pilar utama kami</p>
        </div>
    </div>
</section>

<!-- PROGRAM -->
<section id="program" class="py-24 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-slate-500 font-medium text-sm uppercase tracking-wider">Program Kami</span>
            <h2 class="text-4xl font-bold text-slate-800 mt-3">Pilar Pengembangan Anak</h2>
            <p class="text-slate-600 mt-4 max-w-2xl mx-auto">Tiga program utama yang kami jalankan untuk memastikan setiap anak mendapat perhatian penuh.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Education -->
            <div class="card-hover bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Pendidikan</h3>
                <p class="text-slate-600 leading-relaxed">Mendukung pendidikan formal dari SD hingga perguruan tinggi dengan bimbingan belajar dan fasilitas perpustakaan.</p>
            </div>
            <!-- Health -->
            <div class="card-hover bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Kesehatan</h3>
                <p class="text-slate-600 leading-relaxed">Pemeriksaan rutin, gizi seimbang, dan catatan kesehatan yang terpantau untuk setiap anak asuh kami.</p>
            </div>
            <!-- Food -->
            <div class="card-hover bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Pangan & Gizi</h3>
                <p class="text-slate-600 leading-relaxed">Pemenuhan kebutuhan pangan bergizi sehari-hari dengan pengelolaan stok yang transparan dan terorganisir.</p>
            </div>
        </div>
    </div>
</section>

<!-- PUBLIC LIBRARY PREVIEW -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-slate-500 font-medium text-sm uppercase tracking-wider">Koleksi Kami</span>
            <h2 class="text-3xl font-bold text-slate-800 mt-3">Perpustakaan Digital</h2>
            <p class="text-slate-600 mt-4 max-w-2xl mx-auto">Akses koleksi buku kami yang terus berkembang untuk mendukung pendidikan anak-anak asuh.</p>
        </div>

        <div class="text-center">
            <a href="{{ route('perpustakaan.public.index') }}" class="inline-block bg-slate-800 text-white px-10 py-4 rounded-xl font-semibold hover:bg-slate-700 hover:shadow-lg transition-all">
                Lihat Perpustakaan Lengkap →
            </a>
        </div>
    </div>
</section>

<!-- CALL TO ACTION (DONASI) -->
<section class="py-24 bg-slate-100 text-center">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-slate-800 mb-6">Jadilah Bagian dari Perubahan</h2>
        <p class="text-slate-600 text-lg mb-10">Mulai langkah kebaikan Anda hari ini. Bantuan Anda sangat berarti bagi kelangsungan pendidikan dan kehidupan anak-anak asuh kami.</p>
        <a href="{{ route('donasi.index') }}" class="inline-block bg-slate-800 text-white px-10 py-5 rounded-2xl font-bold text-xl hover:bg-slate-700 hover:-translate-y-1 transition-all shadow-lg hover:shadow-xl">
            Mulai Berdonasi Sekarang
        </a>
    </div>
</section>

<!-- LOGIN MODAL -->
@include('components.login-modal')

@include('layouts.footer')

</body>
</html>

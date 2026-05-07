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
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }

        .bg-slide:nth-child(1) { background-image: url('/images/land1.jpg'); }
        .bg-slide:nth-child(2) { background-image: url('/images/land2.png'); }

        .bg-overlay {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(15,23,42,0.82) 0%, rgba(30,41,59,0.78) 50%, rgba(51,65,85,0.75) 100%);
            z-index: 1;
        }

        .hero-content { position: relative; z-index: 2; }

        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.15); }
        .nav-link { transition: color 0.15s ease; }

        /* PROGRESS BAR ANIMATION */
        .progress-fill { transition: width 1s ease-out; }
        .counter { font-variant-numeric: tabular-nums; }

        /* PROFILE DROPDOWN */
        .profile-dropdown { display: none; }
        .profile-dropdown.open { display: block; }
    </style>
</head>
<body class="bg-white text-slate-800">

<!-- NAVBAR -->
<nav class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <img src="/storage/img/logo-panti.jpg" alt="Logo Panti Asuhan Amaliya" class="h-10 md:h-12 w-auto object-contain" 
         style="aspect-ratio: 1019/277;">
        </div>

        <!-- Nav Links -->
        <div class="hidden md:flex items-center gap-8">
            <a href="#program" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Program</a>
            <a href="{{ route('perpustakaan.public.index') }}" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Perpustakaan</a>
            <a href="#tentang-kami" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Tentang Kami</a>

            @auth
            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profile-btn" onclick="toggleProfileDropdown()"
                        class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl font-medium transition-colors">
                    <div class="w-7 h-7 bg-slate-800 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-sm">{{ auth()->user()->username }}</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="profile-dropdown" class="profile-dropdown absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">
                    @if(auth()->user()->role === 'Donatur')
                    <a href="{{ route('donatur.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Dashboard
                    </a>
                    @endif
                    <a href="{{ route('password.change') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors border-t border-slate-100">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pengaturan Akun
                    </a>
                    <div class="border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <!-- Guest Buttons -->
            <button onclick="openRegisterModal()" class="text-slate-600 hover:text-slate-900 font-medium text-sm transition-colors">Daftar Donatur</button>
            <button onclick="openLoginModal()" class="bg-slate-800 text-white px-5 py-2 rounded-lg hover:bg-slate-700 font-medium transition-colors">Masuk</button>
            @endauth
        </div>
    </div>
</nav>

<!-- HERO with Dynamic Background -->
<section class="hero-background min-h-screen flex items-center pt-20 relative">
    <div class="bg-slide" id="slide1"></div>
    <div class="bg-slide" id="slide2"></div>
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
                @guest
                <button onclick="openRegisterModal()" class="border border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white/10 transition-colors">
                    Daftar sebagai Donatur
                </button>
                @else
                <a href="#program" class="border border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white/10 transition-colors">
                    Lihat Program
                </a>
                @endguest
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

<!-- TENTANG KAMI -->
<section id="tentang-kami" class="py-16 bg-gradient-to-r from-slate-50 to-slate-100">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="mb-10">
            <h2 class="text-3xl font-bold text-slate-800 mb-3">Tentang Kami</h2>
            <p class="text-slate-600 text-lg leading-relaxed">
                Yayasan Panti Asuhan Amaliya didedikasikan untuk memberikan masa depan yang lebih baik bagi anak-anak asuh kami melalui pendidikan, kesehatan, dan pemenuhan gizi yang layak.
            </p>
        </div>

        <a href="#" class="inline-block bg-slate-800 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-700 hover:shadow-lg transition-all">
            Identitas Yayasan & Lebih Lanjut
        </a>
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
            <div class="card-hover bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Kesehatan</h3>
                <p class="text-slate-600 leading-relaxed">Pemeriksaan rutin, gizi seimbang, dan catatan kesehatan yang terpantau untuk setiap anak asuh kami.</p>
            </div>
            <div class="card-hover bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
                <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-3">Pangan &amp; Gizi</h3>
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

<!-- CALL TO ACTION -->
<section class="py-24 bg-slate-100 text-center">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-slate-800 mb-6">Jadilah Bagian dari Perubahan</h2>
        <p class="text-slate-600 text-lg mb-10">Mulai langkah kebaikan Anda hari ini. Bantuan Anda sangat berarti bagi kelangsungan pendidikan dan kehidupan anak-anak asuh kami.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('donasi.index') }}" class="inline-block bg-slate-800 text-white px-10 py-5 rounded-2xl font-bold text-xl hover:bg-slate-700 hover:-translate-y-1 transition-all shadow-lg hover:shadow-xl">
                Mulai Berdonasi Sekarang
            </a>
            @guest
            <button onclick="openRegisterModal()" class="inline-block border-2 border-slate-800 text-slate-800 px-10 py-5 rounded-2xl font-bold text-xl hover:bg-slate-800 hover:text-white hover:-translate-y-1 transition-all">
                Daftar sebagai Donatur
            </button>
            @endguest
        </div>
    </div>
</section>

<!-- SUCCESS FLASH (from account request) -->
@if(session('success'))
<div id="landing-flash" class="fixed bottom-6 right-6 z-50 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-start gap-3 max-w-sm">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    <p class="text-sm font-medium">{{ session('success') }}</p>
    <button onclick="document.getElementById('landing-flash').remove()" class="ml-2 text-white/70 hover:text-white">✕</button>
</div>
@endif

<!-- LOGIN MODAL -->
@include('components.login-modal')

<!-- REGISTER MODAL -->
@include('components.register-modal')

@include('layouts.footer')

<script>
    // --- BACKGROUND CROSSFADE ---
    const slide1 = document.getElementById('slide1');
    const slide2 = document.getElementById('slide2');
    let current = 0;

    function showSlide(idx) {
        slide1.style.opacity = idx === 0 ? '0.35' : '0';
        slide2.style.opacity = idx === 1 ? '0.35' : '0';
        current = idx;
    }

    // Start with slide 1
    showSlide(0);

    // Crossfade every 5 seconds
    setInterval(function() {
        showSlide(current === 0 ? 1 : 0);
    }, 5000);

    // --- PROFILE DROPDOWN ---
    function toggleProfileDropdown() {
        const dd = document.getElementById('profile-dropdown');
        dd.classList.toggle('open');
    }

    // Close when clicking outside
    document.addEventListener('click', function(e) {
        const btn = document.getElementById('profile-btn');
        const dd  = document.getElementById('profile-dropdown');
        if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target)) {
            dd.classList.remove('open');
        }
    });
</script>

</body>
</html>

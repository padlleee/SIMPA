{{-- ============================================================
     Public Landing Page: resources/views/landing.blade.php
     Refactored to use Blade templating (@extends, @section,
     @include, @push) – no more standalone HTML structure.
     ============================================================ --}}
@extends('layouts.master')

@section('title', 'Beranda')
@section('meta-description', 'Sistem Informasi Manajemen Panti Asuhan Amaliya – transparansi donasi dan pengelolaan panti.')
@section('body-class', 'bg-white text-slate-800')

@section('body')

{{-- PUBLIC NAVBAR --}}
@include('layouts.navbar')

{{-- HERO with Dynamic Background --}}
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
                @auth
                    @if(auth()->user()->role === 'Donatur')
                    <a href="{{ route('donatur.donasi.create') }}" class="bg-white text-slate-800 px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-100 transition-colors">
                        Donasi Sekarang
                    </a>
                    @else
                    <a href="{{ route('donasi.publicCreate') }}" class="bg-white text-slate-800 px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-100 transition-colors">
                        Donasi Sekarang
                    </a>
                    @endif
                @else
                <a href="{{ route('donasi.publicCreate') }}" class="bg-white text-slate-800 px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-100 transition-colors">
                    Donasi Sekarang
                </a>
                @endauth
                @guest
                <button onclick="openRegisterModal()" class="border border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white/10 transition-colors">
                    Daftar sebagai Donatur
                </button>
                @else
                <a href="{{ route('tentang-kami') }}" class="border border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white/10 transition-colors">
                    Tentang Kami
                </a>
                @endguest
            </div>
        </div>

        {{-- Stats Card --}}
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

{{-- TENTANG KAMI --}}
<section id="tentang-kami" class="py-16 bg-gradient-to-r from-slate-50 to-slate-100">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="mb-10">
            <h2 class="text-3xl font-bold text-slate-800 mb-3">Tentang Kami</h2>
            <p class="text-slate-600 text-lg leading-relaxed">
                Yayasan Panti Asuhan Amaliya didedikasikan untuk memberikan masa depan yang lebih baik bagi anak-anak asuh kami melalui pendidikan, kesehatan, dan pemenuhan gizi yang layak.
            </p>
        </div>
        <a href="{{ route('tentang-kami') }}" class="inline-block bg-slate-800 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-700 hover:shadow-lg transition-all">
            Identitas Yayasan &amp; Lebih Lanjut
        </a>
    </div>
</section>



{{-- PUBLIC LIBRARY PREVIEW --}}
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

{{-- CALL TO ACTION --}}
<section class="py-24 bg-slate-100 text-center">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-slate-800 mb-6">Jadilah Bagian dari Perubahan</h2>
        <p class="text-slate-600 text-lg mb-10">Mulai langkah kebaikan Anda hari ini. Bantuan Anda sangat berarti bagi kelangsungan pendidikan dan kehidupan anak-anak asuh kami.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            @auth
                @if(auth()->user()->role === 'Donatur')
                <a href="{{ route('donatur.donasi.create') }}" class="inline-block bg-slate-800 text-white px-10 py-5 rounded-2xl font-bold text-xl hover:bg-slate-700 hover:-translate-y-1 transition-all shadow-lg hover:shadow-xl">
                    Mulai Berdonasi Sekarang
                </a>
                @else
                <a href="{{ route('donasi.publicCreate') }}" class="inline-block bg-slate-800 text-white px-10 py-5 rounded-2xl font-bold text-xl hover:bg-slate-700 hover:-translate-y-1 transition-all shadow-lg hover:shadow-xl">
                    Mulai Berdonasi Sekarang
                </a>
                @endif
            @else
            <a href="{{ route('donasi.publicCreate') }}" class="inline-block bg-slate-800 text-white px-10 py-5 rounded-2xl font-bold text-xl hover:bg-slate-700 hover:-translate-y-1 transition-all shadow-lg hover:shadow-xl">
                Mulai Berdonasi Sekarang
            </a>
            @endauth
            @guest
            <button onclick="openRegisterModal()" class="inline-block border-2 border-slate-800 text-slate-800 px-10 py-5 rounded-2xl font-bold text-xl hover:bg-slate-800 hover:text-white hover:-translate-y-1 transition-all">
                Daftar sebagai Donatur
            </button>
            @endguest
        </div>
    </div>
</section>

{{-- SUCCESS FLASH --}}
@if(session('success'))
<div id="landing-flash" class="fixed bottom-6 right-6 z-50 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-start gap-3 max-w-sm">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    <p class="text-sm font-medium">{{ session('success') }}</p>
    <button onclick="document.getElementById('landing-flash').remove()" class="ml-2 text-white/70 hover:text-white">✕</button>
</div>
@endif

{{-- LOGIN MODAL --}}
@include('components.login-modal')

{{-- REGISTER MODAL --}}
@include('components.register-modal')

{{-- FOOTER --}}
@include('layouts.footer')

@endsection

@push('scripts')
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

    showSlide(0);
    setInterval(function() { showSlide(current === 0 ? 1 : 0); }, 5000);
</script>
@endpush

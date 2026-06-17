{{-- ============================================================
     Public Landing Page: resources/views/landing.blade.php
     Refactored to use Blade templating (@extends, @section,
     @include, @push) – no more standalone HTML structure.
     ============================================================ --}}
@extends('layouts.master')

@section('title', 'Beranda')
@section('meta-description', 'Mendukung Kehidupan yang Lebih Baik – Sistem Informasi Manajemen Panti Asuhan Amaliya.')
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
            <h1 class="text-5xl md:text-6xl font-bold text-white leading-tight mb-4">
                Mendukung<br>
                <span class="text-slate-300">Kehidupan yang<br>Lebih Baik</span>
            </h1>
            <p class="text-slate-300 text-lg leading-relaxed mb-8">
                Support for Better Life
                <span class="text-white/40 mx-2">|</span>
                <em class="text-white/70">Bersama menumbuhkan harapan setiap anak</em>
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

                {{-- Legalitas Panti Button --}}
                <button id="btn-legalitas"
                        onclick="document.getElementById('modal-legalitas').classList.remove('hidden')"
                        class="flex items-center gap-2 text-white/70 hover:text-white text-sm font-medium mt-1 transition-colors group">
                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Legalitas Panti
                </button>
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

{{-- ============================================================ --}}
{{-- SECTION A: TENTANG KAMI BILINGUAL                           --}}
{{-- ============================================================ --}}
<section id="tentang-kami" class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="inline-block text-xs font-bold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-4">Tentang Kami · About Us</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Misi Kami untuk Masa Depan Anak Bangsa</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-start mb-12">
            {{-- Kolom Indonesia --}}
            <div class="space-y-5">
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-8 h-1 bg-slate-800 rounded-full block"></span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Bahasa Indonesia</span>
                </div>
                <p class="text-slate-700 leading-relaxed text-[15px]">
                    Yayasan Panti Asuhan Amaliya berdiri sebagai wadah kasih dan harapan bagi anak-anak yang membutuhkan. Kami berkomitmen untuk memberikan perlindungan, pendidikan berkualitas, dan lingkungan tumbuh kembang yang sehat bagi setiap anak asuh kami.
                </p>
                <p class="text-slate-600 leading-relaxed text-[15px]">
                    Melalui program pembinaan karakter, bimbingan belajar, dan dukungan kesehatan, kami mendorong setiap anak untuk meraih potensi terbaik mereka dan menjadi generasi penerus bangsa yang tangguh dan berakhlak mulia.
                </p>
            </div>

            {{-- Kolom English --}}
            <div class="space-y-5 border-l-0 md:border-l border-slate-200 md:pl-12">
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-8 h-1 bg-slate-300 rounded-full block"></span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">English</span>
                </div>
                <p class="text-slate-500 leading-relaxed text-[15px] italic">
                    Amaliya Orphanage Foundation stands as a vessel of love and hope for children in need. We are committed to providing protection, quality education, and a healthy environment for growth and development for each of our children.
                </p>
                <p class="text-slate-400 leading-relaxed text-[15px] italic">
                    Through character-building programs, tutoring, and healthcare support, we empower every child to reach their full potential and grow into a resilient and noble generation of the nation.
                </p>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('tentang-kami') }}"
               class="inline-flex items-center gap-2 bg-slate-800 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                Lihat Selengkapnya
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- SECTION B: HOW YOU CAN HELP (FAQ PREVIEW GRID)              --}}
{{-- ============================================================ --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="inline-block text-xs font-bold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-4">Cara Berkontribusi · How You Can Help</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Ada Banyak Cara untuk Berbagi Kebaikan</h2>
            <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Setiap kontribusi Anda, sekecil apapun, memiliki dampak nyata bagi kehidupan anak-anak asuh kami.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Card 1: Donasi --}}
            <div class="group relative bg-slate-50 rounded-2xl p-8 border border-slate-200 hover:border-slate-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-slate-800 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Memberikan Donasi</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Send Donation</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Salurkan donasi uang tunai, sembako, pakaian, atau peralatan belajar. Setiap donasi dicatat secara transparan dan terverifikasi di sistem kami.
                </p>
                <p class="text-slate-400 text-xs italic mb-6">
                    Donate cash, food staples, clothing, or school supplies. Every donation is transparently recorded and verified in our system.
                </p>
                <a href="{{ route('faq') }}#donasi" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-slate-900 transition-colors">
                    Pelajari Lebih Lanjut <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Card 2: Relawan --}}
            <div class="group relative bg-slate-50 rounded-2xl p-8 border border-slate-200 hover:border-slate-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-slate-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Menjadi Relawan</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Become a Volunteer</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Dedikasikan waktu dan keahlian Anda untuk mengajar, membimbing, atau mendampingi anak-anak asuh kami dalam kegiatan dan program pembinaan.
                </p>
                <p class="text-slate-400 text-xs italic mb-6">
                    Dedicate your time and skills to teach, guide, or accompany our children in daily activities and development programs.
                </p>
                <a href="{{ route('faq') }}#relawan" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-slate-900 transition-colors">
                    Pelajari Lebih Lanjut <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Card 3: Beasiswa --}}
            <div class="group relative bg-slate-50 rounded-2xl p-8 border border-slate-200 hover:border-slate-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 bg-slate-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Mensponsori Beasiswa</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Sponsor for Scholarship</p>
                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                    Sponsori biaya pendidikan seorang anak asuh dari SD hingga perguruan tinggi. Investasi terbaik untuk masa depan generasi bangsa.
                </p>
                <p class="text-slate-400 text-xs italic mb-6">
                    Sponsor the education costs from elementary to university. The best investment for the nation's future generation.
                </p>
                <a href="{{ route('faq') }}#beasiswa" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 hover:text-slate-900 transition-colors">
                    Pelajari Lebih Lanjut <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- SECTION C: TESTIMONIALS / KISAH ANAK ASUH                   --}}
{{-- ============================================================ --}}
<section class="py-20 bg-gradient-to-br from-slate-800 to-slate-900">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="inline-block text-xs font-bold text-slate-400 uppercase tracking-widest bg-white/10 px-4 py-1.5 rounded-full mb-4">Kisah Nyata · Real Stories</span>
            <h2 class="text-3xl md:text-4xl font-bold text-white">Mereka yang Telah Kami Dampingi</h2>
            <p class="text-slate-400 mt-4 max-w-2xl mx-auto">Setiap kisah adalah bukti nyata bahwa kepedulian bersama dapat mengubah takdir seorang anak.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            {{-- Titi --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/15 hover:border-white/30 hover:bg-white/15 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">T</div>
                    <div>
                        <div class="font-bold text-white text-lg">Titi</div>
                        <div class="text-slate-400 text-sm">Perempuan, 16 tahun &middot; Female, 16 y.o.</div>
                        <div class="flex gap-0.5 mt-1">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                </div>
                <blockquote class="text-slate-300 text-[15px] leading-relaxed mb-5 italic">
                    "Sejak tinggal di panti, saya merasakan hangat keluarga yang sesungguhnya. Bapak dan Ibu pengasuh selalu mendukung impian saya untuk menjadi guru. Di sini saya belajar bahwa keterbatasan bukanlah penghalang untuk berprestasi."
                </blockquote>
                <p class="text-slate-500 text-sm italic leading-relaxed">
                    "Since living at the orphanage, I have felt the warmth of a true family. The caregivers always support my dream of becoming a teacher. Here I learn that limitations are not a barrier to achievement."
                </p>
            </div>

            {{-- Handani --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/15 hover:border-white/30 hover:bg-white/15 transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-slate-500 to-slate-700 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">H</div>
                    <div>
                        <div class="font-bold text-white text-lg">Handani</div>
                        <div class="text-slate-400 text-sm">Laki-laki, 17 tahun &middot; Male, 17 y.o.</div>
                        <div class="flex gap-0.5 mt-1">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                </div>
                <blockquote class="text-slate-300 text-[15px] leading-relaxed mb-5 italic">
                    "Yayasan Amaliya bukan sekadar tempat tinggal. Ini adalah rumah yang membentuk karakter dan mental saya. Program belajar mandiri dan bimbingan karir yang diberikan membantu saya menemukan passion di bidang teknologi informasi."
                </blockquote>
                <p class="text-slate-500 text-sm italic leading-relaxed">
                    "The Amaliya Foundation is not just a place to live. It is a home that has shaped my character and mindset. The self-study programs and career guidance have helped me discover my passion in information technology."
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- SECTION D: RECENT ACTIVITIES / BLOG PREVIEW                 --}}
{{-- ============================================================ --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="inline-block text-xs font-bold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-4">Aktivitas Terkini · Recent Activities</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Kabar Terbaru dari Kami</h2>
                <p class="text-slate-500 mt-3 max-w-xl">Ikuti perkembangan terkini kegiatan dan program yang berjalan di Yayasan Amaliya.</p>
            </div>
            <a href="{{ route('blog.index') }}"
               class="flex-shrink-0 inline-flex items-center gap-2 border border-slate-300 text-slate-700 px-6 py-3 rounded-xl font-semibold hover:border-slate-800 hover:text-slate-800 transition-all duration-200">
                Lihat Semua Blog
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if(isset($recent_posts) && $recent_posts->count())

        {{-- Featured Post Banner --}}
        @php $featuredPost = $recent_posts->first(); @endphp
        <div id="featured-post-container" class="mb-8 relative">
            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="featured-post block" id="featured-post-link">
                @if($featuredPost->image)
                    <img src="{{ asset('storage/' . $featuredPost->image) }}"
                         alt="{{ $featuredPost->title }}"
                         class="featured-post-img w-full"
                         id="featured-post-img">
                @else
                    <div class="featured-post-placeholder" id="featured-post-img"></div>
                @endif
                <div class="featured-post-content">
                    <span class="featured-post-label">Artikel Unggulan</span>
                    <h3 class="featured-post-title" id="featured-post-title">{{ $featuredPost->title }}</h3>
                    <p class="featured-post-meta" id="featured-post-meta">
                        {{ $featuredPost->created_at->locale('id')->translatedFormat('j F Y') }}
                        @if($featuredPost->author) · {{ $featuredPost->author->username }} @endif
                    </p>
                </div>
            </a>

            @if($recent_posts->count() > 1)
            {{-- Chevron Prev --}}
            <button class="featured-nav-btn prev" onclick="featuredNav(-1)" aria-label="Artikel sebelumnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            {{-- Chevron Next --}}
            <button class="featured-nav-btn next" onclick="featuredNav(1)" aria-label="Artikel berikutnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Dot indicators --}}
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-20" id="featured-dots">
                @foreach($recent_posts as $i => $p)
                    <button onclick="featuredGoTo({{ $i }})" class="w-2 h-2 rounded-full bg-white/40 hover:bg-white/80 transition-all {{ $i === 0 ? '!bg-white w-6' : '' }}"
                            id="featured-dot-{{ $i }}"></button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Remaining articles grid --}}
        @if($recent_posts->count() > 1)
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($recent_posts->skip(1) as $post)
            <a href="{{ route('blog.show', $post->slug) }}"
               class="group flex gap-4 items-start bg-white border border-slate-200 rounded-2xl p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16M14 14l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-slate-400 mb-1">{{ $post->created_at->locale('id')->translatedFormat('j M Y') }}</p>
                    <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-slate-600 transition-colors">{{ $post->title }}</h3>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $post->excerpt }}</p>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        @else
        <div class="text-center py-16 bg-slate-50 rounded-2xl border border-slate-200">
            <div class="text-5xl mb-4">📰</div>
            <p class="text-slate-500 font-semibold">Belum ada artikel yang dipublikasikan.</p>
            <p class="text-slate-400 text-sm mt-2">Pantau terus halaman blog kami!</p>
            <a href="{{ route('blog.index') }}" class="inline-block mt-6 bg-slate-800 text-white px-6 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors text-sm">
                Ke Halaman Blog
            </a>
        </div>
        @endif
    </div>
</section>

{{-- ============================================================ --}}
{{-- SECTION E: VOLUNTEER RECRUITMENT CTA BANNER                 --}}
{{-- ============================================================ --}}
<section class="py-0 bg-white">
    <div class="max-w-6xl mx-auto px-6 pb-20">
        <div class="relative bg-gradient-to-r from-slate-800 via-slate-700 to-slate-800 rounded-3xl overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px), radial-gradient(circle at 80% 50%, white 1px, transparent 1px); background-size: 40px 40px;"></div>
            <div class="relative z-10 px-8 md:px-14 py-14 flex flex-col md:flex-row items-center justify-between gap-10">
                <div class="text-center md:text-left max-w-xl">
                    <span class="inline-block text-xs font-bold text-slate-300 uppercase tracking-widest bg-white/10 px-4 py-1.5 rounded-full mb-5">Relawan Pendidikan · Educational Volunteers</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
                        Kami Membutuhkan<br>Relawan Berdedikasi
                    </h2>
                    <p class="text-slate-300 text-[15px] leading-relaxed mb-3">
                        Bergabunglah bersama kami sebagai relawan pengajar untuk membimbing anak-anak asuh dalam berbagai bidang — dari matematika dan sains hingga seni dan teknologi.
                    </p>
                    <p class="text-slate-400 text-sm italic">
                        Join us as a teaching volunteer to guide our children in various fields — from mathematics and science to arts and technology.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row md:flex-col gap-4 flex-shrink-0">
                    <a href="{{ route('blog.index') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white text-slate-800 px-8 py-4 rounded-xl font-bold hover:bg-slate-100 hover:shadow-lg transition-all duration-200 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Info Detail
                    </a>
                    <a href="mailto:info.amaliyasubang@gmail.com"
                       class="inline-flex items-center justify-center gap-2 border-2 border-white/40 text-white px-8 py-4 rounded-xl font-bold hover:bg-white/10 hover:border-white/70 transition-all duration-200 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- SECTION: PERPUSTAKAAN KURASI (3 BAGIAN DINAMIS)             --}}
{{-- ============================================================ --}}
<section id="perpustakaan" class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-6xl mx-auto px-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <span class="inline-block text-xs font-bold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-4">Perpustakaan Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Koleksi Buku Pilihan</h2>
                <p class="text-slate-500 mt-3 max-w-xl">Jelajahi koleksi buku perpustakaan kami yang terus berkembang untuk mendukung pendidikan anak-anak asuh.</p>
            </div>
            <a href="{{ route('perpustakaan.public.index') }}"
               class="flex-shrink-0 inline-flex items-center gap-2 border border-slate-300 text-slate-700 px-6 py-3 rounded-xl font-semibold hover:border-slate-800 hover:text-slate-800 transition-all duration-200">
                Lihat Semua Koleksi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Tab Navigation – Capsule Pill Style (Image 3) --}}
        <div class="pill-tabs mb-10 cat-scroll">
            <button id="lib-tab-sering" onclick="switchLibTab('sering_dipinjam')"
                    class="pill-tab lib-tab active">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Sering Dipinjam
                <span class="pill-count">{{ $bukuSeringDipinjam->count() }}</span>
            </button>
            <button id="lib-tab-baru" onclick="switchLibTab('buku_baru')"
                    class="pill-tab lib-tab">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Buku Baru
                <span class="pill-count">{{ $bukuBaru->count() }}</span>
            </button>
            <button id="lib-tab-unik" onclick="switchLibTab('buku_unik')"
                    class="pill-tab lib-tab">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                Buku Unik
                <span class="pill-count">{{ $bukuUnik->count() }}</span>
            </button>
        </div>

        {{-- ── Panel: Sering Dipinjam ─────────────────────────────── --}}
        <div id="lib-panel-sering_dipinjam" class="lib-panel">
            @if($bukuSeringDipinjam->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($bukuSeringDipinjam as $buku)
                @include('landing._book_card', ['buku' => $buku, 'badge' => 'Sering Dipinjam', 'badgeClass' => 'bg-slate-800 text-white'])
                @endforeach
            </div>
            @else
            @include('landing._empty_books', ['icon' => '📊', 'label' => 'Buku Sering Dipinjam'])
            @endif
        </div>

        {{-- ── Panel: Buku Baru ──────────────────────────────────── --}}
        <div id="lib-panel-buku_baru" class="lib-panel hidden">
            @if($bukuBaru->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($bukuBaru as $buku)
                @include('landing._book_card', ['buku' => $buku, 'badge' => 'Buku Baru', 'badgeClass' => 'bg-emerald-100 text-emerald-800'])
                @endforeach
            </div>
            @else
            @include('landing._empty_books', ['icon' => '✨', 'label' => 'Buku Baru'])
            @endif
        </div>

        {{-- ── Panel: Buku Unik ──────────────────────────────────── --}}
        <div id="lib-panel-buku_unik" class="lib-panel hidden">
            @if($bukuUnik->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($bukuUnik as $buku)
                @include('landing._book_card', ['buku' => $buku, 'badge' => 'Buku Unik', 'badgeClass' => 'bg-amber-100 text-amber-800'])
                @endforeach
            </div>
            @else
            @include('landing._empty_books', ['icon' => '🌟', 'label' => 'Buku Unik'])
            @endif
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

{{-- ============================================================ --}}
{{-- MODAL: LEGALITAS PANTI                                       --}}
{{-- Triggered by clicking "Legalitas Panti" button in the hero. --}}
{{-- ============================================================ --}}
<div id="modal-legalitas"
     class="hidden fixed inset-0 z-[999] flex items-center justify-center p-4"
     onclick="if(event.target===this)this.classList.add('hidden')">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm"></div>

    {{-- Modal Card --}}
    <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">

        {{-- Header --}}
        <div class="bg-slate-800 px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white/15 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-white font-bold text-base">Legalitas Panti Asuhan</div>
                    <div class="text-slate-400 text-xs">Yayasan Amaliya Subang — Dokumen Resmi</div>
                </div>
            </div>
            <button onclick="document.getElementById('modal-legalitas').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 space-y-4">
            <p class="text-slate-600 text-sm leading-relaxed">
                Yayasan Panti Asuhan Amaliya beroperasi secara resmi dan sah secara hukum berdasarkan dokumen-dokumen berikut yang dikeluarkan oleh instansi pemerintah yang berwenang.
            </p>

            {{-- Document List --}}
            <div class="space-y-3">

                {{-- Item 1 --}}
                <div class="flex items-start gap-3 bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-200">
                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800">Akta Notaris Pendirian Yayasan</div>
                        <div class="text-xs text-slate-500 mt-0.5">Nomor Akta: 12/YA/III/2015 — Notaris Subang</div>
                        <span class="inline-block mt-1.5 text-xs font-semibold text-green-700 bg-green-100 px-2 py-0.5 rounded-full">✓ Terverifikasi</span>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="flex items-start gap-3 bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-200">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800">Izin Operasional Dinas Sosial</div>
                        <div class="text-xs text-slate-500 mt-0.5">Dinas Sosial Kabupaten Subang — Diperbaharui 2023</div>
                        <span class="inline-block mt-1.5 text-xs font-semibold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">✓ Aktif 2023–2026</span>
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="flex items-start gap-3 bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-200">
                    <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800">NPWP Yayasan</div>
                        <div class="text-xs text-slate-500 mt-0.5">Nomor Pokok Wajib Pajak Resmi Terdaftar</div>
                        <span class="inline-block mt-1.5 text-xs font-semibold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">✓ Terdaftar Pajak</span>
                    </div>
                </div>

                {{-- Item 4 --}}
                <div class="flex items-start gap-3 bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-200">
                    <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4.5 h-4.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-800">Sertifikat Akreditasi Lembaga Sosial</div>
                        <div class="text-xs text-slate-500 mt-0.5">Kementerian Sosial Republik Indonesia</div>
                        <span class="inline-block mt-1.5 text-xs font-semibold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full">✓ Terakreditasi</span>
                    </div>
                </div>

            </div>

            <p class="text-xs text-slate-400 text-center">
                Untuk verifikasi dan salinan dokumen resmi, hubungi kami di
                <a href="mailto:info.amaliyasubang@gmail.com" class="text-slate-600 underline hover:text-slate-800">info.amaliyasubang@gmail.com</a>
            </p>
        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6">
            <button onclick="document.getElementById('modal-legalitas').classList.add('hidden')"
                    class="w-full bg-slate-800 text-white py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors text-sm">
                Tutup
            </button>
        </div>

    </div>
</div>

{{-- SUCCESS FLASH --}}
@if(session('success'))
<div id="landing-flash" class="fixed bottom-6 right-6 z-50 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-start gap-3 max-w-sm">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    <p class="text-sm font-medium">{{ session('success') }}</p>
    <button onclick="document.getElementById('landing-flash').remove()" class="ml-2 text-white/70 hover:text-white">&#x2715;</button>
</div>
@endif

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

    // ── LIBRARY TAB SWITCHER ─────────────────────────────────────
    const tabMap = {
        'sering_dipinjam': { tab: 'lib-tab-sering', panel: 'lib-panel-sering_dipinjam', badge: 'bg-slate-800 text-white' },
        'buku_baru':       { tab: 'lib-tab-baru',   panel: 'lib-panel-buku_baru',        badge: 'bg-emerald-100 text-emerald-800' },
        'buku_unik':       { tab: 'lib-tab-unik',   panel: 'lib-panel-buku_unik',        badge: 'bg-amber-100 text-amber-800' },
    };

    function switchLibTab(key) {
        // Deactivate all panels and tabs
        document.querySelectorAll('.lib-panel').forEach(function(p) { p.classList.add('hidden'); });
        document.querySelectorAll('.lib-tab').forEach(function(t) {
            t.classList.remove('active');
        });

        // Activate selected tab & panel
        const cfg = tabMap[key];
        if (!cfg) return;
        document.getElementById(cfg.panel).classList.remove('hidden');
        const activeTab = document.getElementById(cfg.tab);
        if (activeTab) {
            activeTab.classList.add('active');
        }
    }

    // ── FEATURED POST SLIDER ──────────────────────────────────────
    @if(isset($recent_posts) && $recent_posts->count() > 1)
    @php
        $fpData = $recent_posts->map(function($p) {
            return [
                'title'  => $p->title,
                'url'    => route('blog.show', $p->slug),
                'image'  => $p->image ? asset('storage/' . $p->image) : null,
                'date'   => $p->created_at->locale('id')->translatedFormat('j F Y'),
                'author' => optional($p->author)->username,
            ];
        })->values();
    @endphp
    const featuredPosts = {!! json_encode($fpData) !!};
    let featuredIdx = 0;

    function featuredNav(dir) {
        featuredGoTo((featuredIdx + dir + featuredPosts.length) % featuredPosts.length);
    }

    function featuredGoTo(idx) {
        featuredIdx = idx;
        const p = featuredPosts[idx];
        const link   = document.getElementById('featured-post-link');
        const imgEl  = document.getElementById('featured-post-img');
        const titleEl = document.getElementById('featured-post-title');
        const metaEl  = document.getElementById('featured-post-meta');

        if (link) link.href = p.url;
        if (titleEl) titleEl.textContent = p.title;
        if (metaEl)  metaEl.textContent  = p.date + (p.author ? ' · ' + p.author : '');
        if (imgEl && p.image) {
            imgEl.src = p.image;
            imgEl.alt = p.title;
        }

        document.querySelectorAll('[id^="featured-dot-"]').forEach(function(dot, i) {
            if (i === idx) {
                dot.style.width = '24px';
                dot.style.background = 'rgba(255,255,255,0.9)';
            } else {
                dot.style.width = '8px';
                dot.style.background = 'rgba(255,255,255,0.35)';
            }
        });
    }
    @endif
</script>
@endpush

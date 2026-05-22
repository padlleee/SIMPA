{{-- ============================================================
     Public Page: Tentang Kami – Foundation Identity & Legalitas
     @extends('layouts.master')
     ============================================================ --}}
@extends('layouts.master')

@section('title', 'Tentang Kami')
@section('meta-description', 'Profil, struktur organisasi, legalitas, dan lokasi Yayasan Panti Asuhan Amaliya Subang.')
@section('body-class', 'bg-white text-slate-800')

@section('body')

@include('layouts.navbar')

{{-- PAGE HERO --}}
<section class="pt-32 pb-16 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <span class="inline-block text-xs font-semibold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-5">Profil Yayasan</span>
        <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-5 leading-tight">Yayasan Panti Asuhan<br><span class="text-slate-500">Amaliya Subang</span></h1>
        <p class="text-slate-600 text-lg leading-relaxed max-w-2xl mx-auto">
            Berdiri sejak lebih dari satu dekade, Yayasan Amaliya Subang hadir untuk memberikan perlindungan, pendidikan, dan kehidupan yang layak bagi anak-anak yang membutuhkan.
        </p>
    </div>
</section>

{{-- VISI & MISI --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-slate-800 rounded-2xl p-8 text-white">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold mb-3">Visi</h2>
                <p class="text-slate-300 leading-relaxed">
                    Menjadi lembaga sosial terpercaya yang mampu mencetak generasi penerus bangsa yang bertakwa, berilmu, dan berakhlak mulia.
                </p>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-8">
                <div class="w-10 h-10 bg-slate-200 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-3">Misi</h2>
                <ul class="text-slate-600 leading-relaxed space-y-2 text-sm">
                    <li class="flex gap-2"><span class="text-slate-400 mt-0.5">▸</span> Memberikan pendidikan formal dan non-formal berkualitas</li>
                    <li class="flex gap-2"><span class="text-slate-400 mt-0.5">▸</span> Memenuhi kebutuhan sandang, pangan, dan kesehatan anak asuh</li>
                    <li class="flex gap-2"><span class="text-slate-400 mt-0.5">▸</span> Membangun karakter Islami melalui pembinaan akhlak</li>
                    <li class="flex gap-2"><span class="text-slate-400 mt-0.5">▸</span> Mengelola donasi secara transparan dan akuntabel</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- STRUKTUR ORGANISASI --}}
<section class="py-16 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Kepengurusan</span>
            <h2 class="text-3xl font-bold text-slate-800 mt-3">Struktur Organisasi</h2>
            <p class="text-slate-500 mt-3 max-w-xl mx-auto text-sm">Tim pengurus yang berdedikasi dalam menjalankan amanah yayasan.</p>
        </div>

        {{-- Top row - Ketua --}}
        <div class="flex justify-center mb-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 text-center w-64 shadow-sm">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Ketua Yayasan</div>
                <div class="font-bold text-slate-800">H. Ahmad Fathoni, S.Ag</div>
                <div class="text-xs text-slate-500 mt-1">Periode 2020 – 2025</div>
            </div>
        </div>

        {{-- Middle row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto mb-6">
            @foreach([
                ['pos' => 'Sekretaris', 'nama' => 'Hj. Siti Nurjanah, S.Pd'],
                ['pos' => 'Bendahara',  'nama' => 'Bpk. Dadan Suherman, S.E'],
            ] as $p)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 text-center shadow-sm">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $p['pos'] }}</div>
                <div class="font-semibold text-slate-800 text-sm">{{ $p['nama'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- Bottom row - Pengurus --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['pos' => 'Pengurus Harian', 'nama' => 'Ust. Yusuf Hidayat'],
                ['pos' => 'Pengasuh',        'nama' => 'Ustadzah Rina Amalia'],
                ['pos' => 'Koordinator Didik','nama' => 'Bpk. Hendra Kusuma'],
                ['pos' => 'Humas',           'nama' => 'Ibu Neni Marliani'],
            ] as $p)
            <div class="bg-white border border-slate-200 rounded-2xl p-4 text-center shadow-sm">
                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">{{ $p['pos'] }}</div>
                <div class="font-medium text-slate-700 text-sm">{{ $p['nama'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- LEGALITAS --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Dokumen Resmi</span>
            <h2 class="text-3xl font-bold text-slate-800 mt-3">Legalitas Yayasan</h2>
            <p class="text-slate-500 mt-3 max-w-xl mx-auto text-sm">Yayasan Amaliya Subang beroperasi secara legal dan terdaftar pada instansi pemerintah yang berwenang.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['icon' => '📜', 'title' => 'Akta Notaris',         'issuer' => 'Notaris H. Dede Kurniawan, SH', 'no' => 'No. 12 / 2013'],
                ['icon' => '🏛️', 'title' => 'SK Kemenkumham',       'issuer' => 'Kementerian Hukum & HAM RI',    'no' => 'AHU-XXXX.AH.01.04'],
                ['icon' => '🤝', 'title' => 'Dinas Sosial',         'issuer' => 'Dinas Sosial Kab. Subang',      'no' => 'No. 460/XXX/Dinsos'],
                ['icon' => '🧾', 'title' => 'NPWP Yayasan',         'issuer' => 'Direktorat Jenderal Pajak',     'no' => '12.345.678.9-XXX.000'],
            ] as $doc)
            <div class="group bg-slate-50 border border-slate-200 rounded-2xl p-6 hover:border-slate-400 transition-colors relative overflow-hidden">
                {{-- Placeholder stamp --}}
                <div class="absolute top-3 right-3">
                    <span class="text-xs font-bold text-slate-300 border border-slate-200 rounded-md px-1.5 py-0.5 rotate-6 inline-block">PLACEHOLDER</span>
                </div>
                <div class="text-4xl mb-4">{{ $doc['icon'] }}</div>
                <h3 class="font-bold text-slate-800 mb-1">{{ $doc['title'] }}</h3>
                <p class="text-xs text-slate-500 mb-2">{{ $doc['issuer'] }}</p>
                <p class="text-xs font-mono text-slate-400 bg-slate-100 rounded px-2 py-1 inline-block">{{ $doc['no'] }}</p>
            </div>
            @endforeach
        </div>

        <p class="text-center text-xs text-slate-400 mt-8">
            Salinan dokumen asli tersedia untuk ditinjau oleh mitra atau donatur korporat yang memerlukan verifikasi.
            Hubungi kami di <span class="text-slate-600 font-medium">info.amaliyasubang@gmail.com</span>
        </p>
    </div>
</section>

{{-- LOKASI --}}
<section class="py-16 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-10">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Kunjungi Kami</span>
            <h2 class="text-3xl font-bold text-slate-800 mt-3">Lokasi Yayasan</h2>
        </div>
        <div class="grid md:grid-cols-5 gap-8 items-start">
            {{-- Map embed --}}
            <div class="md:col-span-3 rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
                <iframe
                    src="https://maps.google.com/maps?q=-6.570183,107.757358&z=16&output=embed"
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi Yayasan Amaliya Subang">
                </iframe>
            </div>
            {{-- Address detail --}}
            <div class="md:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <h3 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Alamat Lengkap</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Blok Suka Asih I RT. 64/18<br>
                        Kel. Karanganyar, Kec. Subang<br>
                        Kab. Subang, Jawa Barat 41211<br>
                        Indonesia
                    </p>
                    <a href="https://maps.google.com/?q=-6.570183,107.757358" target="_blank" rel="noopener noreferrer"
                       class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <h3 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Jam Operasional</h3>
                    <ul class="text-sm text-slate-600 space-y-1.5">
                        <li class="flex justify-between"><span>Senin – Jumat</span><span class="font-medium">08.00 – 16.00</span></li>
                        <li class="flex justify-between"><span>Sabtu</span><span class="font-medium">08.00 – 12.00</span></li>
                        <li class="flex justify-between text-slate-400"><span>Minggu / Hari Libur</span><span>Tutup</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-slate-800 text-white text-center">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-4">Bergabung Dalam Misi Mulia Ini</h2>
        <p class="text-slate-400 mb-8">Setiap donasi Anda dicatat secara transparan dan digunakan sepenuhnya untuk kesejahteraan anak-anak asuh.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('donasi.publicCreate') }}"
               class="bg-white text-slate-800 px-8 py-3 rounded-xl font-semibold hover:bg-slate-100 transition-colors">
               Donasi Sekarang
            </a>
            <a href="{{ route('pendaftaran-anak.create') }}"
               class="border border-white/30 text-white px-8 py-3 rounded-xl font-semibold hover:bg-white/10 transition-colors">
               Daftarkan Anak Asuh
            </a>
        </div>
    </div>
</section>

@include('layouts.footer')
@endsection

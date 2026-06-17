{{-- ============================================================
     Public Page: Tentang Kami – Foundation Identity & Legalitas
     @extends('layouts.master')
     ============================================================ --}}
@extends('layouts.master')

@section('title', 'Tentang Kami')
@section('meta-description', 'Profil, struktur organisasi, legalitas, dan lokasi Yayasan Panti Asuhan Amaliya Subang.')
@section('body-class', 'bg-white text-slate-800')

@push('styles')
<style>
    /* Marquee Animation */
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(calc(-1 * (var(--slide-width) * var(--num-items) + var(--gap) * var(--num-items)))); }
    }
    
    .marquee-container {
        display: flex;
        overflow: hidden;
        position: relative;
        width: 100%;
        mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
    }
    
    .marquee-content {
        display: flex;
        gap: var(--gap);
        /* Animation: linear, infinite */
        animation: marquee 40s linear infinite;
        width: max-content;
    }
    
    .marquee-container:hover .marquee-content {
        animation-play-state: paused;
    }

    /* Lightbox Styles */
    #lightbox {
        backdrop-filter: blur(4px);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    #lightbox.active {
        opacity: 1;
        pointer-events: auto;
    }
</style>
@endpush

@section('body')

@include('layouts.navbar')

{{-- PAGE HERO & CORE PILLARS --}}
<section class="pt-32 pb-16 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <span class="inline-block text-xs font-semibold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-5">Profil Yayasan</span>
        <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4 leading-tight">Yayasan Panti Asuhan<br><span class="text-slate-500">Amaliya Subang</span></h1>
        <p class="text-slate-600 text-lg leading-relaxed max-w-2xl mx-auto mb-16 font-medium">
            Mendukung kehidupan yang lebih baik | Support for better life
        </p>
        
       {{-- HOW YOU CAN HELP PILLARS --}}
        <div class="grid md:grid-cols-3 gap-6 text-left">
            {{-- Pillar 1 --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Memberikan Advokasi</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Membimbing dan membela hak-hak anak yatim dan dhuafa.</p>
            </div>
            {{-- Pillar 2 --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Menjadi Orang Tua Asuh</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Mengasuh dan membiayai kebutuhan pendidikan anak secara berkelanjutan.</p>
            </div>
            {{-- Pillar 3 --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Sponsor Fasilitas Pendukung</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Mendukung penyediaan sarana asrama, ruang belajar, dan fasilitas literasi.</p>
            </div>
        </div>
        </div>
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
            <div class="bg-white border border-slate-100 rounded-2xl p-8 shadow-sm">
                <div class="w-10 h-10 bg-slate-200 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-3">Misi</h2>
                <ul class="text-slate-600 leading-relaxed space-y-2 text-sm">
                    <li class="flex gap-2"><span class="text-slate-400 mt-0.5">▸</span> Memenuhi kebutuhan sandang, pangan, dan kesehatan</li>
                    <li class="flex gap-2"><span class="text-slate-400 mt-0.5">▸</span> Memberikan pendidikan formal dan non-formal berkualitas</li>
                    <li class="flex gap-2"><span class="text-slate-400 mt-0.5">▸</span> Membangun karakter Islami melalui pembinaan akhlak mulia</li>
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

        {{-- Row 1 - Top Management --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto mb-6">
            <div class="bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Pembina</div>
                <div class="font-bold text-slate-800">Ibu Tika Mansyuriah & Cici</div>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl p-6 text-center shadow-sm">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Pengawas</div>
                <div class="font-bold text-slate-800">Bapak Muhamad Hery Friyanto, S.T.</div>
            </div>
        </div>

        {{-- Row 2 - Executive Committee --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto mb-6">
            @foreach([
                ['pos' => 'Ketua', 'nama' => 'Ibu Ika Ariyani Solihah, M.Psi.'],
                ['pos' => 'Sekretaris', 'nama' => 'Bapak Andhika Pratama Sahid, S.Kom'],
                ['pos' => 'Bendahara', 'nama' => 'Ibu Nur Fitria, S.I.Kom'],
            ] as $p)
            <div class="bg-white border border-slate-100 rounded-2xl p-5 text-center shadow-sm">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $p['pos'] }}</div>
                <div class="font-bold text-slate-800 text-sm">{{ $p['nama'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- Row 3 - Operations/Officers --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            @foreach([
                ['pos' => 'Pelaksana Kegiatan 1', 'nama' => 'Bapak Robi Wahyu Anugrah, S.Pd'],
                ['pos' => 'Pelaksana Kegiatan 2', 'nama' => 'Ibu Intan Ratnasari, S.Pd'],
                ['pos' => 'Pelaksana Konsumsi', 'nama' => 'Ibu Sandi Widiaseh'],
            ] as $p)
            <div class="bg-white border border-slate-100 rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $p['pos'] }}</div>
                <div class="font-medium text-slate-700 text-sm">{{ $p['nama'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- LEGALITAS --}}
<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Dokumen Resmi</span>
            <h2 class="text-3xl font-bold text-slate-800 mt-3">Legalitas Yayasan</h2>
            <p class="text-slate-500 mt-3 max-w-xl mx-auto text-sm">Yayasan Amaliya Subang beroperasi secara legal dan terdaftar pada instansi pemerintah yang berwenang.</p>
        </div>

        @php
            $dokumenLegal = [
                'Akta Yayasan Amaliya Subang',
                'SK Kemenkumham Yayasan Amaliya Subang',
                'Surat Keterangan Domisili Yayasan Amaliya Subang',
                'Tanda Daftar LKS Dinas Sosial Kabupaten Subang 2021',
                'Tanda Daftar LKS Dinas Sosial Provinsi Jawa Barat 2021',
                'Akreditasi Yayasan Amaliya Subang',
                'Perizinan Berusaha Berbasis Resiko',
                'NPWP Yayasan Amaliya Subang',
            ];
        @endphp

        <div class="marquee-container" style="--slide-width: 250px; --num-items: {{ count($dokumenLegal) }}; --gap: 1.5rem; padding: 10px 0;">
            <div class="marquee-content">
                {{-- Duplikat 2 kali agar animasi looping tanpa jeda/kosong --}}
                @for($i = 0; $i < 2; $i++)
                    @foreach($dokumenLegal as $index => $doc)
                    <div class="w-[250px] shrink-0 group cursor-pointer" onclick="openLightbox('{{ asset('images/legalitas/dokumen-' . ($index + 1) . '.webp') }}', '{{ $doc }}')">
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden hover:border-slate-400 hover:shadow-lg transition-all relative aspect-[3/4]">
                            <div class="absolute inset-0 bg-slate-800/0 group-hover:bg-slate-800/10 transition-colors z-10 flex items-center justify-center">
                                <div class="bg-white/90 text-slate-800 text-xs font-bold px-3 py-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1.5 shadow-sm transform scale-95 group-hover:scale-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                    Perbesar
                                </div>
                            </div>
                            {{-- Gunakan placeholder gambar sementara, nanti user tinggal timpa file aslinya di folder --}}
                            <img src="{{ asset('images/legalitas/dokumen-' . ($index + 1) . '.webp') }}" 
                                 onerror="this.src='https://via.placeholder.com/600x800.png?text=Dokumen+Legalitas'"
                                 alt="{{ $doc }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-slate-800 mt-4 text-center text-sm px-2">{{ $doc }}</h3>
                    </div>
                    @endforeach
                @endfor
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-12">
            Dokumen asli tersedia di sekretariat yayasan untuk ditinjau oleh mitra atau donatur korporat yang memerlukan verifikasi.
            Hubungi kami di <span class="text-slate-600 font-medium">info.amaliyasubang@gmail.com</span>
        </p>
    </div>
</section>

{{-- LIGHBOX OVERLAY --}}
<div id="lightbox" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80" onclick="closeLightbox()">
    <div class="relative max-w-4xl max-h-[90vh] mx-4" onclick="event.stopPropagation()">
        <button onclick="closeLightbox()" class="absolute -top-10 right-0 text-white hover:text-slate-300 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="lightbox-img" src="" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain bg-white">
        <p id="lightbox-caption" class="text-white text-center mt-4 font-medium text-sm"></p>
    </div>
</div>

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
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d990.9324989839868!2d107.7652137!3d-6.5557305!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e693b7e4a9f503b%3A0x999bec720bfe54c4!2sAsrama%20Panti%20Asuhan%20Amaliya%20Subang!5e0!3m2!1sid!2sid!4v1780023357594!5m2!1sid!2sid"
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
        <h2 class="text-3xl font-bold mb-4">Ingin bergabung dalam misi mulia ini?</h2>
        <p class="text-slate-400 mb-8">Setiap donasi Anda dicatat secara transparan dan digunakan sepenuhnya untuk kesejahteraan anak-anak asuh.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('donasi.publicCreate') }}"
               class="bg-white text-slate-800 px-8 py-3 rounded-xl font-semibold hover:bg-slate-100 transition-colors shadow-lg">
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

@push('scripts')
<script>
    function openLightbox(src, caption) {
        // Cek dulu apakah gambar placeholder jika error diload
        const img = new Image();
        img.src = src;
        img.onerror = function() {
            document.getElementById('lightbox-img').src = 'https://via.placeholder.com/1200x1600.png?text=Dokumen+Legalitas';
        };
        img.onload = function() {
            document.getElementById('lightbox-img').src = src;
        };
        
        document.getElementById('lightbox-caption').innerText = caption;
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden'; // prevent background scrolling
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') closeLightbox();
    });
</script>
@endpush

@endsection

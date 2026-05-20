<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan – SIMPA Amaliya</title>
    <meta name="description" content="Jelajahi koleksi buku perpustakaan Panti Asuhan Amaliya Subang.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Hero same style as landing.blade.php */
        .hero-bg {
            background: linear-gradient(135deg, rgba(15,23,42,0.90) 0%, rgba(30,41,59,0.85) 50%, rgba(51,65,85,0.80) 100%);
        }
        .card-hover { transition: transform 0.22s ease, box-shadow 0.22s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.13); }

        /* Horizontal slider within book card */
        .card-info-slider { overflow: hidden; position: relative; }
        .card-info-track {
            display: flex;
            transition: transform 0.35s cubic-bezier(.4,0,.2,1);
            will-change: transform;
        }
        .card-info-slide { flex: 0 0 100%; min-width: 0; }

        /* Dot indicators */
        .dot { width: 6px; height: 6px; border-radius: 50%; background: #cbd5e1; transition: background 0.2s; }
        .dot.active { background: #475569; }

        /* Category pill scroll */
        .cat-scroll { scrollbar-width: none; }
        .cat-scroll::-webkit-scrollbar { display: none; }

        /* Gradient placeholders */
        .grad-1 { background: linear-gradient(135deg,#1e293b,#334155); }
        .grad-2 { background: linear-gradient(135deg,#1d4ed8,#3b82f6); }
        .grad-3 { background: linear-gradient(135deg,#7c3aed,#a78bfa); }
        .grad-4 { background: linear-gradient(135deg,#065f46,#10b981); }
        .grad-5 { background: linear-gradient(135deg,#92400e,#f59e0b); }
        .grad-6 { background: linear-gradient(135deg,#9f1239,#f43f5e); }
    </style>
</head>
<body class="bg-white text-slate-800">

<!-- NAVBAR — same as landing.blade.php -->
<nav class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="/images/logo-panti.png" alt="Logo Panti Asuhan Amaliya"
                 class="h-10 md:h-12 w-auto object-contain" style="aspect-ratio:1019/277"
                 onerror="this.style.display='none'">
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a href="/" class="text-slate-600 hover:text-slate-900 font-medium transition-colors">Beranda</a>
            <a href="{{ route('login') }}" class="bg-slate-800 text-white px-5 py-2 rounded-lg hover:bg-slate-700 font-medium transition-colors">Masuk</a>
        </div>
    </div>
</nav>

<!-- HERO — same dark overlay style as landing -->
<section class="relative min-h-[420px] flex items-center pt-20 overflow-hidden bg-slate-900">
    <div class="hero-bg absolute inset-0 z-10"></div>
    {{-- decorative blur --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl z-0"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl z-0"></div>

    <div class="relative z-20 max-w-6xl mx-auto px-6 py-20 w-full">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            {{-- Left: text + search --}}
            <div class="flex-1 text-center lg:text-left">
                <span class="inline-block bg-white/10 text-white/90 text-sm font-medium px-4 py-1.5 rounded-full mb-6 border border-white/10">
                    Perpustakaan Digital Aktif
                </span>
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-5">
                    Koleksi Buku<br>
                    <span class="text-slate-300">Amaliya</span>
                </h1>
                <p class="text-slate-300 text-lg max-w-xl mx-auto lg:mx-0 mb-8 leading-relaxed">
                    Jelajahi koleksi buku kami yang dirancang untuk mendukung pendidikan dan pengembangan anak-anak asuh Panti Amaliya.
                </p>
                <form method="GET" action="{{ route('perpustakaan.public.index') }}" class="flex gap-3 max-w-lg">
                    <div class="flex-1 relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" placeholder="Cari buku, penulis, atau kategori..." value="{{ request('search') }}"
                               class="w-full pl-11 pr-5 py-3.5 rounded-xl bg-white text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
                    </div>
                    <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3.5 rounded-xl font-semibold text-sm transition-colors whitespace-nowrap">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Right: quick stats --}}
            <div class="grid grid-cols-2 gap-3 lg:w-64 shrink-0">
                @php $totalTersedia = $totalBuku - $totalPinjam; @endphp
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-bold text-white">{{ $totalBuku }}</div>
                    <div class="text-slate-400 text-xs mt-1">Total Eksemplar</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-bold text-white">{{ $buku->total() }}</div>
                    <div class="text-slate-400 text-xs mt-1">Judul Buku</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-bold text-amber-400">{{ $totalPinjam }}</div>
                    <div class="text-slate-400 text-xs mt-1">Dipinjam</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
                    <div class="text-3xl font-bold text-green-400">{{ $totalTersedia }}</div>
                    <div class="text-slate-400 text-xs mt-1">Tersedia</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CATEGORY FILTER (same sticky style as landing nav) -->
@if($kategori->isNotEmpty())
<section class="bg-white border-b border-slate-100 sticky top-[73px] z-40">
    <div class="max-w-6xl mx-auto px-6 py-3 flex items-center gap-2 overflow-x-auto cat-scroll">
        <a href="{{ route('perpustakaan.public.index', array_filter(['search' => request('search')])) }}"
           class="shrink-0 px-4 py-1.5 rounded-lg text-sm font-medium transition-colors
                  {{ !request('kategori') ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            Semua
        </a>
        @foreach($kategori as $kat)
        <a href="{{ route('perpustakaan.public.index', array_filter(['search' => request('search'), 'kategori' => $kat])) }}"
           class="shrink-0 px-4 py-1.5 rounded-lg text-sm font-medium transition-colors
                  {{ request('kategori') === $kat ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            {{ $kat }}
        </a>
        @endforeach
    </div>
</section>
@endif

<!-- BOOKS GRID -->
<section class="py-14 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6">

        @if(request('search') || request('kategori'))
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    @if(request('search')) Hasil: "{{ request('search') }}" @else {{ request('kategori') }} @endif
                </h2>
                <p class="text-slate-500 text-sm mt-0.5">{{ $buku->total() }} buku ditemukan</p>
            </div>
            <a href="{{ route('perpustakaan.public.index') }}" class="text-sm text-slate-500 hover:text-slate-800 font-medium flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Semua buku
            </a>
        </div>
        @else
        <h2 class="text-2xl font-bold text-slate-800 mb-8">Semua Koleksi</h2>
        @endif

        @if($buku->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 mb-12">
            @php $grads = ['grad-1','grad-2','grad-3','grad-4','grad-5','grad-6']; @endphp
            @foreach($buku as $idx => $item)
            @php $available = $item->jumlah_buku - ($item->dipinjam_count ?? 0); @endphp

            <div class="card-hover bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm flex flex-col">
                {{-- Cover --}}
                <div class="relative shrink-0">
                    @if($item->foto_buku && file_exists(public_path('storage/'.$item->foto_buku)))
                        <img src="{{ asset('storage/'.$item->foto_buku) }}"
                             alt="{{ $item->judul_buku }}" class="w-full aspect-[2/3] object-cover">
                    @else
                        <div class="{{ $grads[$idx % 6] }} w-full aspect-[2/3] flex flex-col items-center justify-center p-4">
                            <svg class="w-10 h-10 text-white/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 17.477 5.754 17 7.5 17s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 17.477 18.247 17 16.5 17c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <p class="text-white/60 text-xs font-semibold text-center leading-snug line-clamp-3">{{ $item->judul_buku }}</p>
                        </div>
                    @endif
                    {{-- Availability badge --}}
                    <span class="absolute top-2 right-2 text-[10px] font-bold px-2 py-0.5 rounded-full shadow
                        {{ $available > 0 ? 'bg-green-500 text-white' : 'bg-slate-700/80 text-white/80' }}">
                        {{ $available > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>

                {{-- Static Book Info --}}
                <div class="p-3 pb-2">
                    @if($item->kategori_buku)
                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">{{ $item->kategori_buku }}</span>
                    @endif
                    <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2">{{ $item->judul_buku }}</h3>
                    <p class="text-slate-500 text-xs mt-0.5">{{ $item->pengarang }}</p>
                </div>

                {{-- SLIDING SECTION: Ketersediaan ↔ Info Peminjaman --}}
                <div class="border-t border-slate-100 mt-auto">
                    <div class="card-info-slider" data-idx="{{ $idx }}">
                        <div class="card-info-track">
                            {{-- Slide 1: Ketersediaan --}}
                            <div class="card-info-slide p-3">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Ketersediaan</p>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-slate-500">Total</span>
                                    <span class="font-semibold text-slate-700">{{ $item->jumlah_buku }}</span>
                                </div>
                                <div class="flex justify-between text-xs mb-2">
                                    <span class="text-slate-500">Dipinjam</span>
                                    <span class="font-semibold text-amber-600">{{ $item->dipinjam_count ?? 0 }}</span>
                                </div>
                                @php $pct = $item->jumlah_buku > 0 ? ($available/$item->jumlah_buku*100) : 0; @endphp
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden mb-1">
                                    <div class="h-1.5 rounded-full {{ $pct > 50 ? 'bg-green-500' : ($pct > 0 ? 'bg-amber-400' : 'bg-slate-300') }}"
                                         style="width:{{ $pct }}%"></div>
                                </div>
                                <div class="flex justify-between text-[10px]">
                                    <span class="text-slate-400">Tersedia</span>
                                    <span class="font-bold {{ $available > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $available }}</span>
                                </div>
                            </div>

                            {{-- Slide 2: Info Peminjaman --}}
                            <div class="card-info-slide p-3">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Info Peminjaman</p>
                                <div class="space-y-1.5 text-xs text-slate-600">
                                    <div class="flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Durasi peminjaman <strong>2 minggu</strong></span>
                                    </div>
                                    <div class="flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        <span>Khusus anggota komunitas</span>
                                    </div>
                                    <div class="flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Hubungi pengurus panti</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Slide Controls --}}
                    <div class="flex items-center justify-between px-3 py-2 border-t border-slate-50">
                        <button onclick="prevSlide({{ $idx }})" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <div class="flex gap-1.5 items-center" id="dots-{{ $idx }}">
                            <div class="dot active" id="dot-{{ $idx }}-0"></div>
                            <div class="dot" id="dot-{{ $idx }}-1"></div>
                        </div>
                        <button onclick="nextSlide({{ $idx }})" class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($buku->hasPages())
        <div class="flex justify-center">{{ $buku->links('pagination::tailwind') }}</div>
        @endif

        @else
        <div class="text-center py-24">
            <svg class="w-20 h-20 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h3 class="text-xl font-bold text-slate-600 mb-2">Buku tidak ditemukan</h3>
            <p class="text-slate-400 mb-6 text-sm">Coba gunakan kata kunci yang berbeda.</p>
            <a href="{{ route('perpustakaan.public.index') }}" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-700 transition-colors">
                Lihat Semua Buku
            </a>
        </div>
        @endif
    </div>
</section>

<!-- FOOTER — same as landing -->
<footer class="bg-slate-800 text-gray-300 py-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                    </div>
                    <span class="text-xl font-bold text-white">SIMPA</span>
                </div>
                <p class="text-sm leading-relaxed">Sistem Informasi Manajemen Panti Asuhan Amaliya</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="#program" class="hover:text-white transition-colors">Program</a></li>
                    <li><a href="{{ route('perpustakaan.public.index') }}" class="hover:text-white transition-colors">Perpustakaan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Kontak</h4>
                <p class="text-sm leading-relaxed">Panti Asuhan Amaliya<br>Jl. Pendidikan No. 123<br>Subang, Jawa Barat</p>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} Panti Asuhan Amaliya. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
// Track current slide per card
const slideState = {};

function getTrack(idx) {
    return document.querySelector(`.card-info-slider[data-idx="${idx}"] .card-info-track`);
}
function setSlide(idx, slide) {
    slideState[idx] = slide;
    const track = getTrack(idx);
    if (track) track.style.transform = `translateX(-${slide * 100}%)`;
    // Update dots
    [0, 1].forEach(i => {
        const dot = document.getElementById(`dot-${idx}-${i}`);
        if (dot) dot.classList.toggle('active', i === slide);
    });
}
function nextSlide(idx) {
    const cur = slideState[idx] ?? 0;
    setSlide(idx, cur >= 1 ? 0 : cur + 1);
}
function prevSlide(idx) {
    const cur = slideState[idx] ?? 0;
    setSlide(idx, cur <= 0 ? 1 : cur - 1);
}

// Also support touch/swipe on mobile
document.querySelectorAll('.card-info-slider').forEach(slider => {
    let startX = 0;
    const idx = parseInt(slider.dataset.idx);
    slider.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', e => {
        const diff = startX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 30) diff > 0 ? nextSlide(idx) : prevSlide(idx);
    }, { passive: true });
});
</script>
</body>
</html>

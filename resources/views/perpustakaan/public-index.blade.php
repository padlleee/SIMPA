<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan – SIMPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .book-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .book-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.1); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<!-- NAVBAR -->
<nav class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
        <div class="flex items-center gap-3">
            <img src="/storage/img/logo-panti.png" alt="Logo Panti Asuhan Amaliya" class="h-10 md:h-12 w-auto object-contain" 
         style="aspect-ratio: 1019/277;">
        </div>

            </a>
        </div>
        <div class="hidden md:flex items-center gap-6">
            <a href="/" class="text-slate-600 hover:text-slate-900 font-medium">Beranda</a>
            <a href="{{ route('login') }}" class="bg-slate-800 text-white px-5 py-2 rounded-lg hover:bg-slate-700 font-medium transition-colors">Masuk</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="bg-gradient-to-r from-slate-100 to-slate-50 pt-32 pb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4">Perpustakaan Digital</h1>
        <p class="text-slate-600 text-lg max-w-2xl">Jelajahi koleksi buku kami yang dirancang untuk mendukung pendidikan dan pengembangan anak-anak asuh Panti Amaliya.</p>
    </div>
</section>
<!-- INFO SECTION -->
<section class="py-16 bg-slate-100">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl p-6 border border-slate-200">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Durasi Peminjaman</h3>
                <p class="text-slate-600">Buku dapat dipinjam hingga 2 minggu. Perpanjangan bisa dilakukan jika tidak dipinjam orang lain.</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-slate-200">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Persyaratan</h3>
                <p class="text-slate-600">Hanya tersedia untuk anggota komunitas Panti Amaliya. Login diperlukan untuk meminjam buku.</p>
            </div>

            <div class="bg-white rounded-xl p-6 border border-slate-200">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Koleksi Terus Bertambah</h3>
                <p class="text-slate-600">Kami terus menambahkan buku baru untuk memperkaya koleksi perpustakaan digital kami.</p>
            </div>
        </div>
    </div>
</section>

<!-- SEARCH -->
<section class="bg-white border-b border-slate-200 sticky top-20 z-40">
    <div class="max-w-6xl mx-auto px-6 py-6">
        <form method="GET" action="{{ route('perpustakaan.public.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Cari buku, pengarang, atau kategori..." value="{{ request('search') }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-transparent">
            </div>
            <button type="submit" class="bg-slate-800 text-white px-6 py-3 rounded-lg hover:bg-slate-700 font-medium transition-colors">
                Cari
            </button>
        </form>
    </div>
</section>

<!-- BOOKS GRID -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        @if($buku->count() > 0)
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Daftar Buku Tersedia</h2>
                <p class="text-slate-600">{{ $buku->total() }} buku ditemukan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($buku as $item)
                    <div class="book-card bg-slate-50 rounded-xl overflow-hidden border border-slate-200">
                        <!-- Book Cover Placeholder -->
                        <div class="h-48 bg-gradient-to-br from-slate-700 to-slate-600 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25m20-11.002c5.5 0 10 4.748 10 11.002M4.5 15H4a2 2 0 00-2 2v4a2 2 0 002 2h15a2 2 0 002-2v-4a2 2 0 00-2-2h-.5"/>
                                </svg>
                                <p class="text-slate-400 text-sm font-semibold">E-Book</p>
                            </div>
                        </div>

                        <!-- Book Info -->
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-slate-800 line-clamp-2 mb-2">{{ $item->judul_buku }}</h3>

                            <p class="text-slate-600 text-sm mb-3">{{ $item->pengarang }}</p>

                            @if($item->kategori_buku)
                                <span class="inline-block bg-slate-100 text-slate-700 text-xs font-medium px-3 py-1 rounded-full mb-4">
                                    {{ $item->kategori_buku }}
                                </span>
                            @endif

                            <!-- Availability Status -->
                            <div class="bg-white border border-slate-200 rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-slate-600 text-sm font-medium">Total Eksemplar</p>
                                    <p class="font-bold text-slate-800">{{ $item->jumlah_buku }}</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-slate-600 text-sm font-medium">Sedang Dipinjam</p>
                                    <p class="font-bold text-orange-600">{{ $item->dipinjam_count ?? 0 }}</p>
                                </div>

                                @php
                                    $available = $item->jumlah_buku - ($item->dipinjam_count ?? 0);
                                    $availabilityClass = $available > 0 ? 'text-green-600' : 'text-red-600';
                                @endphp

                                <div class="flex justify-between items-center pt-2 border-t border-slate-200 mt-2">
                                    <p class="text-slate-600 text-sm font-medium">Tersedia</p>
                                    <p class="font-bold {{ $availabilityClass }}">{{ $available }}</p>
                                </div>
                            </div>

                            @if($available > 0)
                                <span class="inline-block bg-green-50 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-lg w-full text-center">
                                    ✓ Tersedia untuk Dipinjam
                                </span>
                            @else
                                <span class="inline-block bg-slate-100 text-slate-600 text-xs font-semibold px-3 py-1.5 rounded-lg w-full text-center">
                                    Sedang Kosong
                                </span>
                            @endif

                            @if($item->kondisi_buku)
                                <p class="text-slate-500 text-xs mt-3">Kondisi: <span class="font-medium">{{ $item->kondisi_buku }}</span></p>
                            @endif
                        </div>

                        <!-- Book Code Badge -->
                        <div class="px-6 pb-4">
                            <p class="text-center text-slate-500 text-xs">Kode: <span class="font-mono font-semibold">{{ $item->kode_buku }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($buku->hasPages())
                <div class="flex justify-center gap-2 mt-12">
                    {{ $buku->links('pagination::tailwind') }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-2xl font-bold text-slate-800 mt-4">Buku Tidak Ditemukan</h3>
                <p class="text-slate-600 mt-2">Coba ubah kata kunci pencarian Anda.</p>
                <a href="{{ route('perpustakaan.public.index') }}" class="inline-block mt-6 bg-slate-800 text-white px-6 py-2.5 rounded-lg hover:bg-slate-700 transition-colors font-medium">
                    Lihat Semua Buku
                </a>
            </div>
        @endif
    </div>
</section>



<!-- FOOTER -->
<footer class="bg-slate-800 text-gray-300 py-12">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">SIMPA</span>
                </div>
                <p class="text-sm">Sistem Informasi Manajemen Panti Asuhan Amaliya</p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="/#program" class="hover:text-white transition-colors">Program</a></li>
                    <li><a href="/#donasi-progress" class="hover:text-white transition-colors">Donasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">Kontak</h4>
                <p class="text-sm">Panti Asuhan Amaliya<br>Jl. Pendidikan No. 123<br>Subang, Jawa Barat</p>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} Panti Asuhan Amaliya. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>

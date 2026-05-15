<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPA') – Panti Asuhan Amaliya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-item { transition: background-color 0.15s ease, color 0.15s ease; }
        .sidebar-item.active { background-color: #f1f5f9; color: #1e293b; font-weight: 600; }
        .sidebar-item.active::after { content: ''; position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 60%; background: #1e293b; border-radius: 2px 0 0 2px; }
        .fade-in { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800">

<div class="flex h-screen overflow-hidden">
    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex flex-col fixed top-0 left-0 h-full z-40">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-slate-800 text-base leading-tight">SIMPA</div>
                    <div class="text-slate-400 text-xs">Yayasan Amaliya Subang</div>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-4 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-3 py-2.5">
                <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-semibold text-slate-700 truncate">{{ auth()->user()->username }}</div>
                    <div class="text-xs text-slate-400">{{ auth()->user()->role }}</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">

            @if(auth()->user()->role !== 'Donatur')
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span class="text-sm">Dashboard</span>
            </a>

            <div class="px-3 pt-4 pb-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Manajemen</span>
            </div>

            <!-- Anak Asuh -->
            <a href="{{ route('anak-asuh.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('anak-asuh*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="text-sm">Anak Asuh</span>
            </a>

            <!-- Donasi -->
            <a href="{{ route('donasi.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donasi*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span class="text-sm">Donasi</span>
            </a>

            <!-- Pengeluaran -->
            <a href="{{ route('pengeluaran.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('pengeluaran*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                <span class="text-sm">Pengeluaran</span>
            </a>

            <div class="px-3 pt-4 pb-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Inventaris</span>
            </div>

            <!-- Stok -->
            <a href="{{ route('stok.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('stok*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span class="text-sm">Gudang (Stok)</span>
            </a>

            <!-- Inventaris -->
            <a href="{{ route('inventaris.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('inventaris*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="text-sm">Inventaris Aset</span>
            </a>

            <!-- Perpustakaan -->
            <a href="{{ route('perpustakaan.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('perpustakaan*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span class="text-sm">Perpustakaan</span>
            </a>

            <div class="px-3 pt-4 pb-1">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sistem</span>
            </div>

            <!-- Users -->
            <a href="{{ route('users.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('users*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span class="text-sm">Pengguna</span>
            </a>

            @if(auth()->user()->role === 'Admin')
            <!-- Account Requests -->
            @php $sidebarReqs = \App\Models\AccountRequest::where('status','pending')->count(); @endphp
            <a href="{{ route('account-request.index') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('account-request*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span class="text-sm flex-1">Permintaan Akun</span>
                @if($sidebarReqs > 0)
                <span class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $sidebarReqs }}</span>
                @endif
            </a>
            @endif

            @else
            <!-- Donatur Sidebar -->
            <a href="{{ route('donatur.dashboard') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donatur.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                <span class="text-sm">Dashboard Saya</span>
            </a>
            <a href="{{ route('donatur.profile') }}" class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donatur.profile') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-sm">Profil Saya</span>
            </a>
            @endif
        </nav>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-slate-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors text-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 ml-64 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-xl font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                <p class="text-slate-400 text-sm mt-0.5">@yield('page-subtitle', '')</p>
            </div>
            <div class="flex items-center gap-3">

                @if(auth()->user()->role !== 'Donatur')
                @php
                    // === Kumpulkan semua notifikasi ===
                    $notifs = [];

                    // 1. Donasi Pending
                    if(in_array(auth()->user()->role, ['Admin','Bendahara'])) {
                        $pendingDonations = \App\Models\Donasi::with(['user.donatur'])
                            ->where('status_verifikasi','Pending')
                            ->latest('tanggal_donasi')->get();
                        foreach($pendingDonations as $don) {
                            $namaDonatur = $don->user?->donatur?->nama_donatur
                                ?? $don->user?->username
                                ?? $don->nama_donatur_manual
                                ?? 'Anonim';
                            $jenisLabel = $don->id_donatur ? 'Donatur Tetap' : 'Publik';
                            $notifs[] = [
                                'type'    => 'donasi',
                                'icon'    => 'heart',
                                'color'   => 'yellow',
                                'title'   => 'Donasi masuk dari ' . $namaDonatur,
                                'sub'     => $jenisLabel,
                                'url'     => route('donasi.show', $don->id_donasi),
                            ];
                        }
                    }

                    // 2. Stok Menipis
                    if(in_array(auth()->user()->role, ['Admin','Ketua'])) {
                        $lowStocks = \App\Models\StokPanti::where('stok_akhir', '<=', 5)->get();
                        foreach($lowStocks as $stok) {
                            $notifs[] = [
                                'type'    => 'stok',
                                'icon'    => 'box',
                                'color'   => 'orange',
                                'title'   => 'Stok "' . $stok->nama_barang . '" menipis',
                                'sub'     => 'Sisa ' . $stok->stok_akhir . ' ' . ($stok->satuan ?? 'unit'),
                                'url'     => route('stok.index', ['filter'=>'menipis']),
                            ];
                        }
                    }

                    // 3. Deadline Peminjaman Buku (terlambat dikembalikan)
                    if(in_array(auth()->user()->role, ['Admin','Ketua'])) {
                        $terlambat = \App\Models\PeminjamanBuku::with('buku')
                            ->where('status', 'Dipinjam')
                            ->where('tanggal_kembali', '<', now()->toDateString())
                            ->get();
                        foreach($terlambat as $pinjam) {
                            $notifs[] = [
                                'type'    => 'buku',
                                'icon'    => 'book',
                                'color'   => 'red',
                                'title'   => 'Buku "' . ($pinjam->buku?->judul_buku ?? '-') . '" terlambat',
                                'sub'     => 'Peminjam: ' . $pinjam->nama_peminjam . ' | Tenggat: ' . \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y'),
                                'url'     => route('perpustakaan.index'),
                            ];
                        }
                    }

                    // 4. Permintaan Akun Pending
                    if(auth()->user()->role === 'Admin') {
                        $pendingReqs = \App\Models\AccountRequest::where('status','pending')->get();
                        foreach($pendingReqs as $req) {
                            $notifs[] = [
                                'type'    => 'akun',
                                'icon'    => 'user',
                                'color'   => 'blue',
                                'title'   => 'Permintaan akun dari ' . $req->nama_lengkap,
                                'sub'     => 'Menunggu persetujuan',
                                'url'     => route('account-request.index', ['status'=>'pending']),
                            ];
                        }
                    }

                    $totalNotifs = count($notifs);
                @endphp

                {{-- Bell Notification Button --}}
                <div class="relative" id="notif-wrapper">
                    <button id="notif-btn" onclick="toggleNotif()" class="relative p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($totalNotifs > 0)
                        <span class="absolute top-0.5 right-0.5 bg-red-500 text-white text-[10px] font-bold min-w-[16px] h-4 px-0.5 rounded-full flex items-center justify-center">
                            {{ $totalNotifs > 9 ? '9+' : $totalNotifs }}
                        </span>
                        @endif
                    </button>

                    {{-- Pop-up Panel --}}
                    <div id="notif-panel" class="hidden absolute right-0 top-12 w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 overflow-hidden">
                        {{-- Header --}}
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">Notifikasi</h3>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $totalNotifs }} notifikasi baru</p>
                            </div>
                            <button onclick="toggleNotif()" class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- Notification List --}}
                        <div class="max-h-96 overflow-y-auto divide-y divide-slate-50">
                            @forelse($notifs as $notif)
                            <a href="{{ $notif['url'] }}" onclick="toggleNotif()" class="flex items-start gap-3 px-5 py-3.5 hover:bg-slate-50 transition-colors group">
                                {{-- Icon --}}
                                <div class="shrink-0 mt-0.5 w-8 h-8 rounded-lg flex items-center justify-center
                                    {{ $notif['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ $notif['color'] === 'orange' ? 'bg-orange-100 text-orange-600' : '' }}
                                    {{ $notif['color'] === 'red'    ? 'bg-red-100 text-red-600' : '' }}
                                    {{ $notif['color'] === 'blue'   ? 'bg-blue-100 text-blue-600' : '' }}
                                ">
                                    @if($notif['icon'] === 'heart')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    @elseif($notif['icon'] === 'box')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    @elseif($notif['icon'] === 'book')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    @elseif($notif['icon'] === 'user')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                    @endif
                                </div>
                                {{-- Text --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-700 truncate group-hover:text-slate-900">{{ $notif['title'] }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $notif['sub'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            @empty
                            <div class="px-5 py-10 text-center">
                                <svg class="w-10 h-10 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                <p class="text-sm text-slate-400 font-medium">Tidak ada notifikasi</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-8">
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="fade-in mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
            @endif
            @if(session('error'))
            <div class="fade-in mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span class="text-sm">{{ session('error') }}</span>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
<script>
    // === Notification Panel Toggle ===
    function toggleNotif() {
        const panel = document.getElementById('notif-panel');
        if (!panel) return;
        panel.classList.toggle('hidden');
    }

    // Close panel when clicking outside
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('notif-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            const panel = document.getElementById('notif-panel');
            if (panel) panel.classList.add('hidden');
        }
    });
</script>
</body>
</html>

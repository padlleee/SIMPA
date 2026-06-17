{{-- ============================================================
     Partial: layouts/partials/sidebar.blade.php
     Admin & Staff Sidebar Navigation
     @include('layouts.partials.sidebar')
     ============================================================ --}}

<aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex flex-col fixed top-0 left-0 h-full z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300">

    {{-- Logo --}}
    <div class="px-6 py-5 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('images/logo-panti-single.png') }}" alt="Logo SIMPA" class="w-full h-full object-contain">
            </div>
            <div>
                <div class="font-bold text-slate-800 text-base leading-tight">SIMPA</div>
                <div class="text-slate-400 text-xs">Yayasan Amaliya Subang</div>
            </div>
        </div>
    </div>

    {{-- User Info --}}
    <div class="px-4 py-4 border-b border-slate-100">
        <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-3 py-2.5">
            <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-sm font-semibold text-slate-700 truncate">{{ auth()->user()->username }}</div>
                <div class="text-xs text-slate-400">{{ auth()->user()->role }}</div>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-4 overflow-y-auto sidebar-scroll space-y-0.5">

        @if(auth()->user()->role !== 'Donatur')

        <a href="{{ route('dashboard') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            <span class="text-sm">Dashboard</span>
        </a>

        <div class="px-3 pt-4 pb-1">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Manajemen</span>
        </div>

        <a href="{{ route('anak-asuh.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('anak-asuh*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-sm">Anak Asuh</span>
        </a>

        <a href="{{ route('admin.pengurus-nonaktif.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('admin.pengurus-nonaktif*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="text-sm">Arsip Pengurus</span>
        </a>

        <a href="{{ route('donasi.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donasi*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span class="text-sm">Donasi</span>
        </a>

        <a href="{{ route('pengeluaran.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('pengeluaran*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
            </svg>
            <span class="text-sm">Pengeluaran</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('laporan.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('laporan*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm">Laporan</span>
        </a>

        <!-- Blog / Kegiatan -->
        <a href="{{ route('admin.blog.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('admin.blog*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <span class="text-sm">Blog / Kegiatan</span>
        </a>

        <!-- FAQ -->
        <a href="{{ route('admin.faq.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('admin.faq*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm">Kelola FAQ</span>
        </a>

        <div class="px-3 pt-4 pb-1">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Inventaris</span>
        </div>


        <a href="{{ route('stok.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('stok*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span class="text-sm">Gudang (Stok)</span>
        </a>

        <a href="{{ route('inventaris.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('inventaris*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span class="text-sm">Manajemen Peralatan</span>
        </a>

        <a href="{{ route('perpustakaan.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('perpustakaan*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="text-sm">Perpustakaan</span>
        </a>

        <div class="px-3 pt-4 pb-1">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sistem</span>
        </div>

        <a href="{{ route('users.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('users*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="text-sm">Pengguna</span>
        </a>

        @if(auth()->user()->role === 'Admin')
            @php $sidebarReqs = \App\Models\AccountRequest::where('status','pending')->count(); @endphp
            <a href="{{ route('account-request.index') }}"
               class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('account-request*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="text-sm flex-1">Permintaan Akun</span>
                @if($sidebarReqs > 0)
                    <span class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $sidebarReqs }}</span>
                @endif
            </a>
        @endif

        {{-- Pendaftaran Anak Asuh --}}
        @php $pendingPendaftaran = \App\Models\CalonAnakAsuh::where('status','Pending')->count(); @endphp
        <a href="{{ route('admin.pendaftaran.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="text-sm flex-1">Pendaftaran Anak</span>
            @if($pendingPendaftaran > 0)
                <span class="bg-amber-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingPendaftaran }}</span>
            @endif
        </a>


        @else

        {{-- Donatur Sidebar --}}
        <a href="{{ route('donatur.dashboard') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donatur.dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
            </svg>
            <span class="text-sm">Dashboard Saya</span>
        </a>

        <a href="{{ route('donatur.profile') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donatur.profile') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-sm">Profil Saya</span>
        </a>

        <a href="{{ route('donatur.laporan') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donatur.laporan') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17v-6m4 6V7m4 10v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm">Laporan Donasi</span>
        </a>

        <a href="{{ route('donatur.perpustakaan.index') }}"
           class="sidebar-item relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 {{ request()->routeIs('donatur.perpustakaan*') ? 'active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="text-sm">Perpustakaan</span>
        </a>


        @endif

    </nav>

    {{-- Kembali ke Landing Page --}}
    <div class="px-4 pb-2">
        <a href="{{ route('landing') }}"
           class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition-colors text-sm group">
            <svg class="w-5 h-5 flex-shrink-0 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="flex-1">Kembali ke Landing</span>
            <svg class="w-3.5 h-3.5 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>
    </div>

    {{-- Logout --}}
    <div class="px-4 py-4 border-t border-slate-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors text-sm">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </div>

</aside>

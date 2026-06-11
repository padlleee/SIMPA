{{-- ============================================================
     Partial: layouts/navbar.blade.php
     Public Landing Page Navigation Bar
     @include('layouts.navbar')
     ============================================================ --}}

<nav id="main-navbar" class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between gap-6">

        {{-- Logo --}}
        <div class="flex items-center gap-3 flex-shrink-0">
            <img src="/images/logo-panti.png"
                 alt="Logo Panti Asuhan Amaliya"
                 class="h-10 md:h-12 w-auto object-contain"
                 style="aspect-ratio: 1019/277;">
        </div>

        {{-- Nav Links --}}
        <div class="hidden md:flex items-center gap-1 flex-1 justify-center">

            {{-- Beranda – hanya tampil jika bukan di landing page --}}
            @if(!request()->routeIs('landing'))
            <a href="{{ route('landing') }}" class="nav-link px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-all">Beranda</a>
            @endif

            {{-- Dropdown: Seputar Panti --}}
            <div class="relative" id="seputar-wrapper">
                <button id="seputar-btn"
                        onclick="toggleDropdown('seputar-dropdown', 'seputar-btn')"
                        class="nav-link flex items-center gap-1.5 px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-all">
                    Seputar Panti
                    <svg id="seputar-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="seputar-dropdown" class="dropdown-menu" style="min-width:240px; left:0; right:auto;">
                    <a href="{{ route('tentang-kami') }}" class="dropdown-item">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Tentang Kami</p>
                            <p class="text-xs text-slate-400">Profil, Visi, dan Misi Yayasan</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('info') }}" class="dropdown-item">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Pusat Informasi</p>
                            <p class="text-xs text-slate-400">Panduan dan Transparansi</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('blog.index') }}" class="dropdown-item">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Blog</p>
                            <p class="text-xs text-slate-400">Artikel & Kegiatan Panti</p>
                        </div>
                    </a>
                </div>
            </div>

            <a href="{{ route('perpustakaan.public.index') }}" class="nav-link px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-all">Perpustakaan</a>
            <a href="{{ route('faq') }}" class="nav-link px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-all">FAQ</a>

            {{-- Dropdown: Pendaftaran --}}
            <div class="relative" id="pendaftaran-wrapper">
                <button id="pendaftaran-btn"
                        onclick="toggleDropdown('pendaftaran-dropdown', 'pendaftaran-btn')"
                        class="nav-link flex items-center gap-1.5 px-4 py-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium text-sm transition-all">
                    Pendaftaran
                    <svg id="pendaftaran-chevron" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="pendaftaran-dropdown" class="dropdown-menu" style="min-width:240px; left:0; right:auto;">
                    <div class="px-4 py-3 border-b border-slate-50">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pilih Jenis Pendaftaran</p>
                    </div>
                    <a href="{{ route('pendaftaran-anak.create') }}" class="dropdown-item">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Daftar Anak Asuh</p>
                            <p class="text-xs text-slate-400">Formulir penerimaan anak asuh baru</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('account-request.create') }}" class="dropdown-item">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">Permintaan Akun Donatur</p>
                            <p class="text-xs text-slate-400">Daftar sebagai donatur tetap</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Right Section --}}
        <div class="hidden md:flex items-center gap-2 flex-shrink-0">
            @auth
            {{-- Profile Dropdown (Authenticated) --}}
            <div class="relative" id="profile-wrapper">
                <button id="profile-btn"
                        onclick="toggleDropdown('profile-dropdown', 'profile-btn')"
                        class="flex items-center gap-2.5 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 px-3.5 py-2 rounded-xl font-medium transition-all text-sm">
                    <div class="w-7 h-7 bg-slate-800 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <div class="text-xs text-slate-400 leading-none mb-0.5">{{ auth()->user()->role }}</div>
                        <div class="text-sm font-semibold text-slate-800 leading-none truncate max-w-[100px]">{{ auth()->user()->username }}</div>
                    </div>
                    <svg class="w-3.5 h-3.5 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="profile-dropdown" class="dropdown-menu">
                    <div class="px-4 py-3 border-b border-slate-50">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->username }}</p>
                        <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                    </div>

                    @if(auth()->user()->role === 'Donatur')
                    <a href="{{ route('donatur.dashboard') }}" class="dropdown-item">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                        </svg>
                        Dashboard Saya
                    </a>
                    <a href="{{ route('donatur.profile') }}" class="dropdown-item">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Profil Saya
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="dropdown-item">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Admin Dashboard
                    </a>
                    @endif

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('password.change') }}" class="dropdown-item">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Pengaturan Akun
                    </a>

                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item danger">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            @else
            {{-- Guest Buttons --}}
            <button onclick="openRegisterModal()"
                    class="text-slate-600 hover:text-slate-900 font-medium text-sm px-4 py-2 rounded-lg hover:bg-slate-50 transition-all">
                Daftar Donatur
            </button>
            <button onclick="openLoginModal()"
                    class="bg-slate-800 text-white px-5 py-2.5 rounded-xl hover:bg-slate-700 font-semibold text-sm transition-colors shadow-sm">
                Masuk
            </button>
            @endauth
        </div>

    </div>
</nav>

{{-- Global Guest Modals --}}
@guest
    @include('components.login-modal')
    @include('components.register-modal')
@endguest

@push('scripts')
<script>
    /* ── Global dropdown toggle ──────────────────────────────── */
    function toggleDropdown(dropdownId, btnId) {
        const dropdown = document.getElementById(dropdownId);
        const isOpen = dropdown.classList.contains('open');

        // Close all open dropdowns first
        document.querySelectorAll('.dropdown-menu.open').forEach(function(d) {
            d.classList.remove('open');
        });

        // Toggle chevrons back
        document.querySelectorAll('[id$="-chevron"]').forEach(function(c) {
            c.style.transform = '';
        });

        if (!isOpen) {
            dropdown.classList.add('open');
            // Rotate chevron if any
            const btn = document.getElementById(btnId);
            if (btn) {
                const chevron = btn.querySelector('[id$="-chevron"], svg:last-child');
                if (chevron) chevron.style.transform = 'rotate(180deg)';
            }
        }
    }

    /* ── Close when clicking outside ────────────────────────── */
    document.addEventListener('click', function(e) {
        const openDropdowns = document.querySelectorAll('.dropdown-menu.open');
        openDropdowns.forEach(function(dropdown) {
            const id = dropdown.id;
            // Find the associated button
            const btn = document.querySelector('[onclick*="' + id + '"]');
            if (btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
                const chevron = btn.querySelector('svg:last-child');
                if (chevron) chevron.style.transform = '';
            }
        });
    });

    /* ── Legacy compatibility ────────────────────────────────── */
    function toggleProfileDropdown() {
        toggleDropdown('profile-dropdown', 'profile-btn');
    }
</script>
@endpush

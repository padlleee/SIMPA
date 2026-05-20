{{-- ============================================================
     Partial: layouts/navbar.blade.php
     Public Landing Page Navigation Bar
     @include('layouts.navbar')
     ============================================================ --}}

<nav class="fixed top-0 w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <img src="/images/logo-panti.png"
                 alt="Logo Panti Asuhan Amaliya"
                 class="h-10 md:h-12 w-auto object-contain"
                 style="aspect-ratio: 1019/277;">
        </div>

        {{-- Nav Links --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="#program" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Program</a>
            <a href="{{ route('perpustakaan.public.index') }}" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Perpustakaan</a>
            <a href="#tentang-kami" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Tentang Kami</a>
            <a href="#donasi-progress" class="nav-link text-slate-600 hover:text-slate-900 font-medium">Target Donasi</a>

            @auth
            {{-- Profile Dropdown (Authenticated) --}}
            <div class="relative">
                <button id="profile-btn" onclick="toggleProfileDropdown()"
                        class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl font-medium transition-colors">
                    <div class="w-7 h-7 bg-slate-800 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-sm">{{ auth()->user()->username }}</span>
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="profile-dropdown"
                     class="profile-dropdown absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50">

                    @if(auth()->user()->role === 'Donatur')
                    <a href="{{ route('donatur.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                        </svg>
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Dashboard
                    </a>
                    @endif

                    <a href="{{ route('password.change') }}"
                       class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors border-t border-slate-100">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Pengaturan Akun
                    </a>

                    <div class="border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            @else
            {{-- Guest Buttons --}}
            <button onclick="openRegisterModal()"
                    class="text-slate-600 hover:text-slate-900 font-medium text-sm transition-colors">
                Daftar Donatur
            </button>
            <button onclick="openLoginModal()"
                    class="bg-slate-800 text-white px-5 py-2 rounded-lg hover:bg-slate-700 font-medium transition-colors">
                Masuk
            </button>
            @endauth
        </div>

    </div>
</nav>

@push('scripts')
<script>
    function toggleProfileDropdown() {
        const dd = document.getElementById('profile-dropdown');
        dd.classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        const btn = document.getElementById('profile-btn');
        const dd  = document.getElementById('profile-dropdown');
        if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target)) {
            dd.classList.remove('open');
        }
    });
</script>
@endpush

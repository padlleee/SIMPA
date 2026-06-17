{{-- ============================================================
     Partial: layouts/partials/topbar.blade.php
     Top header bar with page title and notification bell
     @include('layouts.partials.topbar')
     ============================================================ --}}

<header class="bg-white border-b border-slate-200 px-4 md:px-8 py-4 flex items-center justify-between flex-shrink-0 dashboard-topbar gap-4">

    {{-- Left side: Hamburger + Title --}}
    <div class="flex items-center gap-3">
        <button onclick="toggleSidebar()" class="p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-lg md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div>
            <h1 class="text-lg md:text-xl font-bold text-slate-800 leading-tight">@yield('page-title', 'Dashboard')</h1>
            <p class="text-slate-400 text-xs md:text-sm mt-0.5 hidden sm:block">@yield('page-subtitle', '')</p>
        </div>
    </div>

    {{-- Right side: Notification + Date --}}
    <div class="flex items-center gap-3">

        {{-- Notifications (non-Donatur only) --}}
        @if(auth()->user()->role !== 'Donatur')
        @php
            $userId = auth()->id();
            $userRole = auth()->user()->role;
            
            // Cache notifikasi selama 60 detik untuk mencegah DB query berat di setiap perpindahan halaman
            $notifs = \Illuminate\Support\Facades\Cache::remember('topbar_notifs_' . $userId, 60, function() use ($userRole) {
                $items = [];

                // 1. Donasi Pending
                if(in_array($userRole, ['Admin','Bendahara'])) {
                    $pendingDonations = \App\Models\Donasi::with(['user.donatur'])
                        ->where('status_verifikasi','Pending')
                        ->latest('tanggal_donasi')->take(10)->get();
                    foreach($pendingDonations as $don) {
                        $namaDonatur = $don->user?->donatur?->nama_donatur
                            ?? $don->user?->username
                            ?? $don->nama_donatur_manual
                            ?? 'Anonim';
                        $jenisLabel = $don->id_donatur ? 'Donatur Tetap' : 'Publik';
                        $items[] = [
                            'type'  => 'donasi',
                            'icon'  => 'heart',
                            'color' => 'yellow',
                            'title' => 'Donasi masuk dari ' . $namaDonatur,
                            'sub'   => $jenisLabel,
                            'url'   => route('donasi.show', $don->id_donasi),
                        ];
                    }
                }

                // 2. Stok Menipis
                if(in_array($userRole, ['Admin','Ketua'])) {
                    $lowStocks = \App\Models\StokPanti::where('stok_akhir', '<=', 5)->take(10)->get();
                    foreach($lowStocks as $stok) {
                        $items[] = [
                            'type'  => 'stok',
                            'icon'  => 'box',
                            'color' => 'orange',
                            'title' => 'Stok "' . $stok->nama_barang . '" menipis',
                            'sub'   => 'Sisa ' . $stok->stok_akhir . ' ' . ($stok->satuan ?? 'unit'),
                            'url'   => route('stok.index', ['filter' => 'menipis']),
                        ];
                    }
                }

                // 3. Buku Terlambat Dikembalikan
                if(in_array($userRole, ['Admin','Ketua'])) {
                    $terlambat = \App\Models\PeminjamanBuku::with('buku')
                        ->where('status', 'Dipinjam')
                        ->where('tanggal_kembali', '<', now()->toDateString())
                        ->take(10)->get();
                    foreach($terlambat as $pinjam) {
                        $items[] = [
                            'type'  => 'buku',
                            'icon'  => 'book',
                            'color' => 'red',
                            'title' => 'Buku "' . ($pinjam->buku?->judul_buku ?? '-') . '" terlambat',
                            'sub'   => 'Peminjam: ' . $pinjam->nama_peminjam . ' | Tenggat: ' . \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y'),
                            'url'   => route('perpustakaan.index'),
                        ];
                    }
                }

                // 4. Permintaan Akun Pending
                if($userRole === 'Admin') {
                    $pendingReqs = \App\Models\AccountRequest::where('status','pending')->take(10)->get();
                    foreach($pendingReqs as $req) {
                        $items[] = [
                            'type'  => 'akun',
                            'icon'  => 'user',
                            'color' => 'blue',
                            'title' => 'Permintaan akun dari ' . $req->nama_lengkap,
                            'sub'   => 'Menunggu persetujuan',
                            'url'   => route('account-request.index', ['status' => 'pending']),
                        ];
                    }
                }
                
                return $items;
            });

            $totalNotifs = count($notifs);
        @endphp

        {{-- Bell Button --}}
        <div class="relative" id="notif-wrapper">
            <button id="notif-btn" onclick="toggleNotif()"
                    class="relative p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if($totalNotifs > 0)
                <span class="absolute top-0.5 right-0.5 bg-red-500 text-white text-[10px] font-bold min-w-[16px] h-4 px-0.5 rounded-full flex items-center justify-center">
                    {{ $totalNotifs > 9 ? '9+' : $totalNotifs }}
                </span>
                @endif
            </button>

            {{-- Notification Panel --}}
            <div id="notif-panel"
                 class="hidden absolute right-0 md:right-0 -right-16 top-12 w-80 md:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 overflow-hidden">

                {{-- Panel Header --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Notifikasi</h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $totalNotifs }} notifikasi baru</p>
                    </div>
                    <button onclick="toggleNotif()" class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Notification List --}}
                <div class="max-h-96 overflow-y-auto divide-y divide-slate-50">
                    @forelse($notifs as $notif)
                    <a href="{{ $notif['url'] }}" onclick="toggleNotif()"
                       class="flex items-start gap-3 px-5 py-3.5 hover:bg-slate-50 transition-colors group">
                        {{-- Icon --}}
                        <div class="shrink-0 mt-0.5 w-8 h-8 rounded-lg flex items-center justify-center
                            {{ $notif['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-600' : '' }}
                            {{ $notif['color'] === 'orange' ? 'bg-orange-100 text-orange-600' : '' }}
                            {{ $notif['color'] === 'red'    ? 'bg-red-100 text-red-600' : '' }}
                            {{ $notif['color'] === 'blue'   ? 'bg-blue-100 text-blue-600' : '' }}">
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
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-500 shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @empty
                    <div class="px-5 py-10 text-center">
                        <svg class="w-10 h-10 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <p class="text-sm text-slate-400 font-medium">Tidak ada notifikasi</p>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
        @endif

        {{-- Current Date --}}
        <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <span class="text-sm text-slate-500 hidden sm:inline">
            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </span>

    </div>
</header>

@push('scripts')
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    function toggleNotif() {
        const panel = document.getElementById('notif-panel');
        if (!panel) return;
        panel.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('notif-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            const panel = document.getElementById('notif-panel');
            if (panel) panel.classList.add('hidden');
        }
    });
</script>
@endpush

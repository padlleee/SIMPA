@extends('layouts.app')

@section('title', 'Permintaan Akun')
@section('page-title', 'Permintaan Akun Donatur')
@section('page-subtitle', 'Tinjau dan proses permintaan akun dari publik')

@section('content')

<!-- Filter Bar -->
<div class="flex flex-wrap items-center gap-3 mb-6">
    <a href="{{ route('account-request.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition {{ !request('status') ? 'bg-slate-800 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        Semua
    </a>
    <a href="{{ route('account-request.index', ['status' => 'pending']) }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition flex items-center gap-2 {{ request('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        Pending
        @if($pendingCount > 0)
        <span class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
        @endif
    </a>
    <a href="{{ route('account-request.index', ['status' => 'approved']) }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        Disetujui
    </a>
    <a href="{{ route('account-request.index', ['status' => 'rejected']) }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
        Ditolak
    </a>
</div>

<!-- Flash Messages -->
@if(session('success'))
<div class="mb-5 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 flex items-start gap-3">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif
@if(session('info'))
<div class="mb-5 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl px-5 py-4 flex items-start gap-3">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span class="text-sm">{{ session('info') }}</span>
</div>
@endif
@if(session('error'))
<div class="mb-5 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 flex items-start gap-3">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
    <span class="text-sm">{{ session('error') }}</span>
</div>
@endif

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($requests->isEmpty())
    <div class="text-center py-16 text-slate-400">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="font-medium">Tidak ada permintaan akun</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600">Nama</th>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600">Tanggal</th>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600">Status</th>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 w-[1%] whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($requests as $req)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">{{ $req->nama_lengkap }}</td>
                    <td class="px-6 py-4 text-slate-500 whitespace-nowrap">{{ $req->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($req->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                            </span>
                        @elseif($req->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Disetujui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap w-[1%]">
                        <div class="flex gap-2 items-center">
                            @if($req->isPending())
                                <form action="{{ route('account-request.approve', $req) }}" method="POST" class="m-0 p-0 flex" onsubmit="return confirm('Setujui permintaan dari {{ $req->nama_lengkap }}?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Setujui"
                                            class="flex items-center justify-center bg-green-100 text-green-700 p-2 rounded-lg hover:bg-green-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <form action="{{ route('account-request.reject', $req) }}" method="POST" class="m-0 p-0 flex" onsubmit="return confirm('Tolak permintaan dari {{ $req->nama_lengkap }}?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Tolak"
                                            class="flex items-center justify-center bg-red-100 text-red-700 p-2 rounded-lg hover:bg-red-200 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            @endif
                            <button type="button" title="Lihat Permintaan"
                                    onclick="showDetailModal('{{ addslashes($req->nama_lengkap) }}', '{{ addslashes($req->email) }}', '{{ addslashes($req->no_hp ?? '-') }}', '{{ addslashes($req->pesan ?? '-') }}')"
                                    class="flex items-center justify-center bg-blue-100 text-blue-700 p-2 rounded-lg hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            @if(!$req->isPending())
                                <span class="text-slate-400 text-xs ml-2 whitespace-nowrap">Ditinjau oleh {{ $req->reviewer?->username ?? '—' }}</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($requests->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $requests->links() }}
    </div>
    @endif
    @endif
</div>

@endsection

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
        <!-- Header -->
        <div class="border-b border-slate-200 p-6 flex justify-between items-center bg-slate-50 rounded-t-2xl">
            <h3 class="text-lg font-bold text-slate-800">Detail Permintaan</h3>
            <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 space-y-5">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap</p>
                <p id="modalDetailName" class="font-medium text-slate-800"></p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</p>
                <p id="modalDetailEmail" class="text-slate-700"></p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">No. HP</p>
                <p id="modalDetailPhone" class="text-slate-700"></p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Pesan / Alasan</p>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <p id="modalDetailMessage" class="text-sm text-slate-600 whitespace-pre-wrap"></p>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="border-t border-slate-200 p-4 text-right">
            <button onclick="closeDetailModal()" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function showDetailModal(name, email, phone, message) {
        document.getElementById('modalDetailName').textContent = name;
        document.getElementById('modalDetailEmail').textContent = email;
        document.getElementById('modalDetailPhone').textContent = phone;
        document.getElementById('modalDetailMessage').textContent = message || '—';
        
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Close on click outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetailModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDetailModal();
        }
    });
</script>

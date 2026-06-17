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
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Nama</th>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Tanggal</th>
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Status</th>
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
                                {{-- Approve Button --}}
                                <button type="button" title="Setujui"
                                    onclick="showConfirmModal('approve', '{{ $req->id }}', '{{ addslashes($req->nama_lengkap) }}')"
                                    class="flex items-center justify-center bg-green-100 text-green-700 p-2 rounded-lg hover:bg-green-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                                {{-- Hidden Approve Form --}}
                                <form id="approve-form-{{ $req->id }}" action="{{ route('account-request.approve', $req) }}" method="POST" class="hidden">
                                    @csrf @method('PATCH')
                                </form>

                                {{-- Reject Button --}}
                                <button type="button" title="Tolak"
                                    onclick="showConfirmModal('reject', '{{ $req->id }}', '{{ addslashes($req->nama_lengkap) }}')"
                                    class="flex items-center justify-center bg-red-100 text-red-700 p-2 rounded-lg hover:bg-red-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                {{-- Hidden Reject Form --}}
                                <form id="reject-form-{{ $req->id }}" action="{{ route('account-request.reject', $req) }}" method="POST" class="hidden">
                                    @csrf @method('PATCH')
                                </form>
                            @endif

                            <button type="button" title="Lihat Permintaan"
                                    onclick="showDetailModal('{{ addslashes($req->nama_lengkap) }}', '{{ addslashes($req->email) }}', '{{ addslashes($req->no_hp ?? '-') }}', '{{ addslashes($req->pesan ?? '-') }}')"
                                    class="flex items-center justify-center bg-blue-100 text-blue-700 p-2 rounded-lg hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>

                            {{-- Delete Button --}}
                            <button type="button" title="Hapus Permintaan"
                                    onclick="showConfirmModal('delete', '{{ $req->id }}', '{{ addslashes($req->nama_lengkap) }}')"
                                    class="flex items-center justify-center bg-slate-100 text-slate-600 p-2 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors ml-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            <form id="delete-form-{{ $req->id }}" action="{{ route('account-request.destroy', $req) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
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

{{-- ===================== MODALS ===================== --}}

<!-- Confirm Modal (Approve/Reject) -->
<div id="confirmModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full overflow-hidden">
        <!-- Header -->
        <div id="confirmModal-header" class="p-6 pb-4">
            <div class="flex items-center gap-4">
                <div id="confirmModal-icon" class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"></div>
                <div>
                    <h3 id="confirmModal-title" class="text-base font-bold text-slate-800"></h3>
                    <p id="confirmModal-sub" class="text-sm text-slate-500 mt-0.5"></p>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="px-6 pb-6 flex gap-3 justify-end">
            <button onclick="closeConfirmModal()" class="px-5 py-2.5 rounded-xl text-sm font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                Batal
            </button>
            <button id="confirmModal-btn" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
        <div class="border-b border-slate-200 p-6 flex justify-between items-center bg-slate-50 rounded-t-2xl">
            <h3 class="text-lg font-bold text-slate-800">Detail Permintaan</h3>
            <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
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
        <div class="border-t border-slate-200 p-4 text-right">
            <button onclick="closeDetailModal()" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // ======= CONFIRM MODAL =======
    let _confirmFormId = null;

    function showConfirmModal(type, id, nama) {
        const modal = document.getElementById('confirmModal');
        const icon  = document.getElementById('confirmModal-icon');
        const title = document.getElementById('confirmModal-title');
        const sub   = document.getElementById('confirmModal-sub');
        const btn   = document.getElementById('confirmModal-btn');

        if (type === 'approve') {
            icon.className  = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-green-100 text-green-600';
            icon.innerHTML  = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`;
            title.textContent = 'Setujui Permintaan?';
            sub.textContent   = `Akun donatur untuk "${nama}" akan segera dibuat.`;
            btn.className     = 'px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors bg-green-600 hover:bg-green-700';
            btn.textContent   = 'Ya, Setujui';
            _confirmFormId    = 'approve-form-' + id;
        } else if (type === 'reject') {
            icon.className  = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-red-100 text-red-600';
            icon.innerHTML  = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
            title.textContent = 'Tolak Permintaan?';
            sub.textContent   = `Permintaan dari "${nama}" akan ditolak.`;
            btn.className     = 'px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors bg-red-600 hover:bg-red-700';
            btn.textContent   = 'Ya, Tolak';
            _confirmFormId    = 'reject-form-' + id;
        } else if (type === 'delete') {
            icon.className  = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 bg-red-100 text-red-600';
            icon.innerHTML  = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`;
            title.textContent = 'Hapus Permintaan?';
            sub.textContent   = `Data permintaan dari "${nama}" akan dihapus permanen.`;
            btn.className     = 'px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors bg-red-600 hover:bg-red-700';
            btn.textContent   = 'Ya, Hapus';
            _confirmFormId    = 'delete-form-' + id;
        }

        modal.classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        _confirmFormId = null;
    }

    document.getElementById('confirmModal-btn').addEventListener('click', function() {
        if (_confirmFormId) {
            document.getElementById(_confirmFormId).submit();
        }
    });

    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirmModal();
    });

    // ======= DETAIL MODAL =======
    function showDetailModal(name, email, phone, message) {
        document.getElementById('modalDetailName').textContent    = name;
        document.getElementById('modalDetailEmail').textContent   = email;
        document.getElementById('modalDetailPhone').textContent   = phone;
        document.getElementById('modalDetailMessage').textContent = message || '—';
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });

    // Close both on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeConfirmModal();
            closeDetailModal();
        }
    });
</script>

@extends('layouts.app')

@section('title', 'Pendaftaran Anak Asuh')
@section('page-title', 'Pendaftaran Calon Anak Asuh')
@section('page-subtitle', 'Tinjauan pengajuan pendaftaran digital yang masuk')

@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6 no-print">
    <form method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Filter Status</label>
            <select name="status" onchange="this.form.submit()"
                    class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none">
                <option value="">Semua Status</option>
                <option value="Pending"   {{ request('status') === 'Pending'   ? 'selected' : '' }}>⏳ Pending</option>
                <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}> Disetujui</option>
                <option value="Ditolak"   {{ request('status') === 'Ditolak'   ? 'selected' : '' }}> Ditolak</option>
            </select>
        </div>
        @if(request('status'))
        <a href="{{ route('admin.pendaftaran.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm hover:bg-slate-200 transition">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="bg-slate-50 border-b border-slate-200 px-5 py-4">
        <h2 class="text-sm font-semibold uppercase text-slate-500">
            Daftar Pengajuan ({{ $registrations->total() }})
        </h2>
    </div>

    @if($registrations->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b border-slate-100 bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Anak</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Wali / Kontak</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Tgl. Lahir</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Dokumen</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($registrations as $calon)
                <tr class="hover:bg-slate-50 transition-colors" id="row-{{ $calon->id }}">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $calon->nama_anak }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">{{ $calon->jenis_kelamin }} · {{ $calon->umur }}</div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <div class="text-slate-700 text-sm">{{ $calon->nama_wali }}</div>
                        <div class="text-xs text-slate-400">{{ $calon->kontak_wali }}</div>
                    </td>
                    <td class="px-5 py-4 text-slate-500 text-xs hidden lg:table-cell whitespace-nowrap">
                        {{ $calon->tanggal_lahir?->locale('id')->translatedFormat('j F Y') }}
                    </td>
                    <td class="px-5 py-4">
                        @if($calon->status === 'Disetujui')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700"> Disetujui</span>
                        @elseif($calon->status === 'Ditolak')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700"> Ditolak</span>
                            @if($calon->catatan_review)
                            <p class="text-xs text-slate-400 mt-1 max-w-[180px]">{{ $calon->catatan_review }}</p>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">⏳ Pending</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 hidden sm:table-cell">
                        @if($calon->dokumen_path)
                            <a href="{{ asset('storage/' . $calon->dokumen_path) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:underline">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Unduh
                            </a>
                        @else
                            <span class="text-slate-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @if($calon->status === 'Pending')
                        <div class="flex flex-col gap-2 items-center">
                            {{-- Approve --}}
                            <form action="{{ route('admin.pendaftaran.approve', $calon->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 rounded-lg text-xs font-semibold transition-colors">
                                     Setujui
                                </button>
                            </form>
                            {{-- Reject toggle --}}
                            <button onclick="toggleRejectForm('reject-{{ $calon->id }}')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-semibold transition-colors">
                                 Tolak
                            </button>
                        </div>
                        {{-- Reject form (hidden by default) --}}
                        <div id="reject-{{ $calon->id }}" class="hidden mt-2">
                            <form action="{{ route('admin.pendaftaran.reject', $calon->id) }}" method="POST" class="space-y-1.5">
                                @csrf @method('PATCH')
                                <textarea name="catatan_review" rows="2" placeholder="Alasan penolakan..."
                                          class="w-full px-2 py-1.5 border border-slate-300 rounded-lg text-xs resize-none focus:outline-none focus:ring-1 focus:ring-slate-400"></textarea>
                                <button type="submit"
                                        class="w-full py-1.5 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition-colors">
                                    Konfirmasi Tolak
                                </button>
                            </form>
                        </div>
                        @else
                            <div class="text-center text-xs text-slate-400">
                                @if($calon->reviewed_at)
                                    {{ $calon->reviewed_at->locale('id')->translatedFormat('j M Y') }}
                                @endif
                                <div>{{ $calon->reviewer?->username ?? '—' }}</div>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $registrations->links() }}
    </div>
    @else
    <div class="py-16 text-center text-slate-400">
        <div class="text-5xl mb-4">📋</div>
        <p class="font-medium text-slate-500">Belum ada pengajuan pendaftaran.</p>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function toggleRejectForm(id) {
    const el = document.getElementById(id);
    el.classList.toggle('hidden');
}
</script>
@endpush

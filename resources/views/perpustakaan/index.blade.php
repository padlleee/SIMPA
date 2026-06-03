@extends('layouts.app')

@section('title', 'Perpustakaan')
@section('page-title', 'Perpustakaan')
@section('page-subtitle', 'Kelola koleksi buku dan peminjaman')

@section('content')

<!-- Search & Add -->
<div class="flex flex-col sm:flex-row gap-4 mb-6">
    <form action="{{ route('perpustakaan.index') }}" method="GET" class="flex gap-3 flex-1">
        <div class="relative flex-1 max-w-sm">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/kata kunci..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700">Cari</button>
    </form>
    <div class="flex gap-2">
        <a href="{{ route('perpustakaan.riwayat') }}" class="bg-white border border-slate-300 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Riwayat
        </a>
        <a href="{{ route('peminjaman.multi.create') }}" class="bg-amber-50 border border-amber-300 text-amber-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-amber-100 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 17.477 5.754 17 7.5 17s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 17.477 18.247 17 16.5 17c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Pinjam Multi-Buku
        </a>
        <a href="{{ route('perpustakaan.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Buku
        </a>
    </div>
</div>

<!-- Book Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
        <h3 class="font-bold text-slate-700">Koleksi Buku</h3>
        <span class="text-xs text-slate-400">{{ $buku->total() }} judul</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="text-left px-6 py-3 font-semibold text-slate-500 w-20 whitespace-nowrap">Kode</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-500 min-w-[200px]">Judul Buku</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Pengarang</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Kategori</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Jml</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Dipinjam</th>
                    <th class="text-right px-6 py-3 font-semibold text-slate-500 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($buku as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-mono text-slate-400 text-xs whitespace-nowrap">{{ $item->kode_buku }}</td>
                <td class="px-4 py-4 min-w-[200px]">
                    <a href="{{ route('perpustakaan.show', $item) }}" class="font-semibold text-slate-800 hover:text-slate-600 transition-colors">{{ $item->judul_buku }}</a>
                    @if($item->tahun_terbit)<div class="text-xs text-slate-400 mt-0.5">{{ $item->tahun_terbit }}</div>@endif
                </td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $item->pengarang }}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($item->kategori_buku)
                    <span class="bg-slate-100 text-slate-600 text-xs px-2 py-0.5 rounded-md">{{ $item->kategori_buku }}</span>
                    @else<span class="text-slate-300 text-xs">—</span>@endif
                </td>
                <td class="px-4 py-4 text-center text-slate-700 font-medium whitespace-nowrap">{{ $item->jumlah_buku }}</td>
                <td class="px-4 py-4 text-center whitespace-nowrap">
                    @if($item->dipinjam_count > 0)
                    <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $item->dipinjam_count }}</span>
                    @else
                    <span class="text-slate-300 text-xs">—</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('perpustakaan.show', $item) }}" title="Detail" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @if($item->dipinjam_count < $item->jumlah_buku)
                        <a href="{{ route('perpustakaan.pinjam', $item) }}" class="px-3 py-1.5 text-xs font-semibold bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-colors">
                            Pinjamkan
                        </a>
                        @else
                        <span class="px-3 py-1.5 text-xs font-semibold bg-slate-100 text-slate-400 rounded-lg">Habis</span>
                        @endif
                        <a href="{{ route('perpustakaan.edit', $item) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form id="del-{{ $item->id_buku }}" action="{{ route('perpustakaan.destroy', $item) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                        <button type="button" 
                                onclick="confirmDeleteBuku('{{ $item->id_buku }}', '{{ addslashes($item->judul_buku) }}', {{ $item->dipinjam_count }}, {{ json_encode($item->peminjamanAktif->map(fn($p) => ['nama' => $p->nama_peminjam, 'kembali' => $p->tanggal_kembali?->format('d M Y')])) }})" 
                                class="p-2 {{ $item->dipinjam_count > 0 ? 'text-amber-500 hover:text-amber-600 hover:bg-amber-50' : 'text-slate-400 hover:text-red-600 hover:bg-red-50' }} rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-16 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                <p>Belum ada koleksi buku</p>
            </td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($buku->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $buku->links() }}</div>
    @endif
</div>

<!-- Active Loans Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
        <h3 class="font-bold text-slate-700">Peminjaman Aktif</h3>
        <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $peminjamanAktif->count() }} Dipinjam</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="text-left px-6 py-3 font-semibold text-slate-500 whitespace-nowrap">Buku</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Peminjam</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Tgl Pinjam</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Batas Kembali</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-500 whitespace-nowrap">Sisa Hari</th>
                    <th class="text-right px-6 py-3 font-semibold text-slate-500 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($peminjamanAktif as $pinjam)
            @php $sisaHari = $pinjam->sisa_hari; $terlambat = $pinjam->terlambat; @endphp
            <tr class="hover:bg-slate-50 transition-colors {{ $terlambat ? 'bg-red-50/50' : '' }}">
                <td class="px-6 py-4 font-semibold text-slate-800 min-w-[200px]">{{ $pinjam->buku?->judul_buku ?? '-' }}</td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $pinjam->nama_peminjam }}</td>
                <td class="px-4 py-4 text-slate-600 text-xs whitespace-nowrap">{{ $pinjam->tanggal_pinjam?->format('d/m/Y') }}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="{{ $terlambat ? 'text-red-600 font-semibold' : 'text-slate-600' }} text-xs">
                        {{ $pinjam->tanggal_kembali?->format('d/m/Y') ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-4 text-center whitespace-nowrap">
                    @if($terlambat)
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-600 font-bold text-xs px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></path></svg>
                            {{ abs($sisaHari) }}h terlambat
                        </span>
                    @elseif($sisaHari === 0)
                        <span class="bg-amber-100 text-amber-700 font-bold text-xs px-2.5 py-1 rounded-full">Hari ini</span>
                    @elseif($sisaHari <= 3)
                        <span class="bg-amber-50 text-amber-600 font-semibold text-xs px-2.5 py-1 rounded-full">{{ $sisaHari }} hari</span>
                    @else
                        <span class="text-slate-500 text-xs font-medium">{{ $sisaHari }} hari</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right whitespace-nowrap">
                    <form id="kembali-{{ $pinjam->id_pinjam }}" action="{{ route('peminjaman.kembalikan', $pinjam) }}" method="POST" class="hidden">
                        @csrf @method('PATCH')
                    </form>
                    <button type="button"
                            onclick="confirmKembali('{{ $pinjam->id_pinjam }}', '{{ addslashes($pinjam->buku?->judul_buku) }}', '{{ addslashes($pinjam->nama_peminjam) }}')"
                            class="px-3 py-1.5 text-xs font-semibold bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                         Kembalikan
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400 text-sm">Tidak ada peminjaman aktif</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

{{-- Modal Buku Sedang Dipinjam --}}
<div id="modalBukuDipinjam" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Buku Sedang Dipinjam</h3>
                <p class="text-sm text-slate-500 mt-0.5">Tidak dapat menghapus buku karena masih ada peminjaman aktif.</p>
            </div>
        </div>
        <div class="bg-slate-50 rounded-xl p-4 mb-5 border border-slate-100">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3">Daftar Peminjam</p>
            <div id="borrowerList" class="space-y-2 max-h-40 overflow-y-auto pr-2"></div>
        </div>
        <button onclick="document.getElementById('modalBukuDipinjam').classList.add('hidden')" class="w-full bg-slate-800 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors">
            Mengerti
        </button>
    </div>
</div>

{{-- Delete Buku Modal --}}
<div id="deleteBukuModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
        <div class="flex items-center gap-4 mb-1">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Hapus Buku?</h3>
                <p id="deleteBukuName" class="text-sm text-slate-500 mt-0.5"></p>
            </div>
        </div>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('deleteBukuModal').classList.add('hidden')" class="flex-1 bg-slate-100 text-slate-700 py-2.5 rounded-xl text-sm font-semibold">Batal</button>
            <button id="deleteBukuConfirm" class="flex-1 bg-red-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700">Hapus</button>
        </div>
    </div>
</div>

{{-- Kembalikan Modal --}}
<div id="kembaliModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
        <div class="flex items-center gap-4 mb-1">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Konfirmasi Pengembalian</h3>
                <p id="kembaliInfo" class="text-sm text-slate-500 mt-0.5"></p>
            </div>
        </div>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('kembaliModal').classList.add('hidden')" class="flex-1 bg-slate-100 text-slate-700 py-2.5 rounded-xl text-sm font-semibold">Batal</button>
            <button id="kembaliConfirm" class="flex-1 bg-green-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-green-700">Ya, Dikembalikan</button>
        </div>
    </div>
</div>

<script>
// Delete buku
let _delId = null;
function confirmDeleteBuku(id, nama, pinjamCount = 0, pinjamData = []) {
    if (pinjamCount > 0) {
        // Tampilkan modal Buku Sedang Dipinjam
        const listDiv = document.getElementById('borrowerList');
        listDiv.innerHTML = pinjamData.map(p => `
            <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-slate-200">
                <span class="font-semibold text-sm text-slate-700">${p.nama}</span>
                <span class="text-xs text-amber-600 bg-amber-50 px-2 py-1 rounded-md font-medium">S/d ${p.kembali}</span>
            </div>
        `).join('');
        document.getElementById('modalBukuDipinjam').classList.remove('hidden');
    } else {
        // Tampilkan modal Konfirmasi Hapus
        _delId = id;
        document.getElementById('deleteBukuName').textContent = '"' + nama + '" akan dihapus permanen.';
        document.getElementById('deleteBukuModal').classList.remove('hidden');
    }
}
document.getElementById('deleteBukuConfirm').addEventListener('click', () => { if(_delId) document.getElementById('del-'+_delId).submit(); });
document.getElementById('deleteBukuModal').addEventListener('click', e => { if(e.target === e.currentTarget) e.currentTarget.classList.add('hidden'); });

// Kembalikan buku
let _kembaliId = null;
function confirmKembali(id, judul, peminjam) {
    _kembaliId = id;
    document.getElementById('kembaliInfo').textContent = '"' + judul + '" dipinjam oleh ' + peminjam + '.';
    document.getElementById('kembaliModal').classList.remove('hidden');
}
document.getElementById('kembaliConfirm').addEventListener('click', () => { if(_kembaliId) document.getElementById('kembali-'+_kembaliId).submit(); });
document.getElementById('kembaliModal').addEventListener('click', e => { if(e.target === e.currentTarget) e.currentTarget.classList.add('hidden'); });

document.addEventListener('keydown', e => {
    if(e.key === 'Escape') {
        document.getElementById('deleteBukuModal').classList.add('hidden');
        document.getElementById('modalBukuDipinjam').classList.add('hidden');
        document.getElementById('kembaliModal').classList.add('hidden');
    }
});
</script>
@endsection

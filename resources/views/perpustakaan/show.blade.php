@extends('layouts.app')

@section('title', $perpustakaan->judul_buku)
@section('page-title', 'Detail Buku')
@section('page-subtitle', 'Informasi lengkap koleksi buku')

@section('content')
<div class="flex gap-6 mb-6">
    <a href="{{ route('perpustakaan.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- LEFT: Cover + Quick Actions --}}
    <div class="lg:col-span-1 space-y-4">
        {{-- Cover --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($perpustakaan->foto_buku && file_exists(public_path('storage/' . $perpustakaan->foto_buku)))
                <img src="{{ asset('storage/' . $perpustakaan->foto_buku) }}" alt="{{ $perpustakaan->judul_buku }}" class="w-full aspect-[2/3] object-cover">
            @else
                <div class="w-full aspect-[2/3] bg-gradient-to-br from-slate-700 to-slate-500 flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 17.477 5.754 17 7.5 17s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 17.477 18.247 17 16.5 17c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span class="text-slate-400 text-sm mt-2 font-medium">Tidak ada sampul</span>
                </div>
            @endif
        </div>

        {{-- Status Ketersediaan --}}
        @php $tersedia = $perpustakaan->jumlah_buku - ($perpustakaan->peminjamanAktif()->count()); @endphp
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-3">
            <h3 class="font-semibold text-slate-700 text-sm">Ketersediaan</h3>
            <div class="flex justify-between text-sm"><span class="text-slate-500">Total Eksemplar</span><span class="font-bold text-slate-800">{{ $perpustakaan->jumlah_buku }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-slate-500">Sedang Dipinjam</span><span class="font-bold text-amber-600">{{ $perpustakaan->jumlah_buku - $tersedia }}</span></div>
            <div class="flex justify-between text-sm border-t border-slate-100 pt-3">
                <span class="text-slate-500">Tersedia</span>
                <span class="font-bold {{ $tersedia > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $tersedia }}</span>
            </div>
            @if($tersedia > 0)
            <a href="{{ route('perpustakaan.pinjam', $perpustakaan) }}" class="block w-full bg-slate-800 text-white text-center py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors">
                Pinjamkan Buku
            </a>
            @else
            <span class="block w-full bg-slate-100 text-slate-400 text-center py-2.5 rounded-xl text-sm font-semibold">Semua Dipinjam</span>
            @endif
        </div>

        {{-- Actions --}}
        @php $peminjamanAktif = $perpustakaan->peminjamanAktif; @endphp
        <div class="flex gap-2">
            <a href="{{ route('perpustakaan.edit', $perpustakaan) }}" class="flex-1 flex items-center justify-center gap-2 border border-slate-300 text-slate-700 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form action="{{ route('perpustakaan.destroy', $perpustakaan) }}" method="POST" class="flex-1" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button"
                        onclick="confirmDelete({{ $peminjamanAktif->count() }}, {{ json_encode($peminjamanAktif->map(fn($p) => ['nama' => $p->nama_peminjam, 'kembali' => $p->tanggal_kembali?->format('d M Y')])) }})"
                        class="w-full flex items-center justify-center gap-2 {{ $peminjamanAktif->count() > 0 ? 'border border-amber-300 text-amber-600 hover:bg-amber-50' : 'border border-red-200 text-red-500 hover:bg-red-50' }} py-2.5 rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- RIGHT: Detail --}}
    <div class="lg:col-span-2 space-y-5">
        {{-- Info Utama --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <div>
                    <span class="font-mono text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">{{ $perpustakaan->kode_buku }}</span>
                    @if($perpustakaan->kategori_buku)
                    <span class="ml-2 text-xs font-medium bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md">{{ $perpustakaan->kategori_buku }}</span>
                    @endif
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                    @if($perpustakaan->kondisi_buku === 'Baru') bg-green-100 text-green-700
                    @elseif($perpustakaan->kondisi_buku === 'Bekas') bg-amber-100 text-amber-700
                    @else bg-slate-100 text-slate-600
                    @endif">
                    {{ $perpustakaan->kondisi_buku ?? '-' }}
                </span>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 mb-1">{{ $perpustakaan->judul_buku }}</h1>
            <p class="text-slate-500 mb-5">oleh <span class="font-medium text-slate-700">{{ $perpustakaan->pengarang }}</span></p>

            <div class="grid grid-cols-2 gap-x-8 gap-y-3 text-sm">
                @if($perpustakaan->penerbit)
                <div><span class="text-slate-400">Penerbit</span><p class="font-medium text-slate-700 mt-0.5">{{ $perpustakaan->penerbit }}</p></div>
                @endif
                @if($perpustakaan->tahun_terbit)
                <div><span class="text-slate-400">Tahun Terbit</span><p class="font-medium text-slate-700 mt-0.5">{{ $perpustakaan->tahun_terbit }}</p></div>
                @endif
                @if($perpustakaan->isbn)
                <div><span class="text-slate-400">ISBN</span><p class="font-mono font-medium text-slate-700 mt-0.5">{{ $perpustakaan->isbn }}</p></div>
                @endif
            </div>

            @if($perpustakaan->sinopsis)
            <div class="mt-5 pt-5 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Sinopsis</p>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $perpustakaan->sinopsis }}</p>
            </div>
            @endif
        </div>

        {{-- Riwayat Peminjaman --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-700">Riwayat Peminjaman</h3>
                <span class="text-xs text-slate-400">{{ $perpustakaan->peminjaman->count() }} transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left px-5 py-3 font-semibold text-slate-500">Peminjam</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-500">Tgl Pinjam</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-500">Batas Kembali</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-500">Dikembalikan</th>
                            <th class="text-center px-4 py-3 font-semibold text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($perpustakaan->peminjaman->sortByDesc('id_pinjam') as $p)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $p->nama_peminjam }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $p->tanggal_pinjam?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $p->tanggal_kembali?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                @if($p->tanggal_dikembalikan)
                                    <span class="{{ $p->tanggal_dikembalikan->lte($p->tanggal_kembali) ? 'text-green-600' : 'text-red-500' }} font-medium">
                                        {{ $p->tanggal_dikembalikan->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($p->status === 'Dipinjam')
                                    @if($p->terlambat)
                                        <span class="bg-red-100 text-red-600 text-xs font-bold px-2.5 py-1 rounded-full">Terlambat</span>
                                    @else
                                        <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">Dipinjam</span>
                                    @endif
                                @else
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400 text-sm">Belum ada riwayat peminjaman</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Buku SEDANG DIPINJAM — peringatan keras --}}
<div id="modalBukuDipinjam" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        {{-- Header peringatan --}}
        <div class="flex items-center gap-4 mb-5">
            <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Buku Sedang Dipinjam!</h3>
                <p class="text-sm text-slate-500 mt-0.5">Buku ini masih dalam status peminjaman aktif.</p>
            </div>
        </div>

        {{-- Daftar peminjam aktif --}}
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-5">
            <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-3">Sedang dipinjam oleh:</p>
            <ul id="listPeminjam" class="space-y-2">
                {{-- Diisi oleh JS --}}
            </ul>
        </div>

        <p class="text-sm text-slate-600 mb-5">Menghapus buku ini akan <span class="font-semibold text-red-600">menghapus seluruh riwayat peminjaman</span> secara permanen, termasuk catatan peminjam yang masih aktif. Tindakan ini tidak dapat dibatalkan.</p>

        <div class="flex gap-3">
            <button onclick="document.getElementById('modalBukuDipinjam').classList.add('hidden')"
                    class="flex-1 bg-slate-100 text-slate-700 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">
                Batal, Kembali
            </button>
            <button id="btnHapusTetap"
                    class="flex-1 bg-red-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors">
                Tetap Hapus
            </button>
        </div>
    </div>
</div>

{{-- Modal: Buku AMAN dihapus — konfirmasi biasa --}}
<div id="modalKonfirmasiHapus" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-800">Hapus Buku?</h3>
                <p class="text-sm text-slate-500 mt-0.5">Data buku dan seluruh riwayat peminjaman akan dihapus permanen.</p>
            </div>
        </div>
        <div class="flex gap-3">
            <button onclick="document.getElementById('modalKonfirmasiHapus').classList.add('hidden')"
                    class="flex-1 bg-slate-100 text-slate-700 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">Batal</button>
            <button id="btnKonfirmasiHapus"
                    class="flex-1 bg-red-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
function confirmDelete(jumlahDipinjam, dataPeminjam) {
    const form = document.getElementById('deleteForm');

    if (jumlahDipinjam > 0) {
        // Buku sedang dipinjam — tampilkan modal peringatan
        const list = document.getElementById('listPeminjam');
        list.innerHTML = '';
        dataPeminjam.forEach(p => {
            list.innerHTML += `
                <li class="flex items-center justify-between bg-white border border-amber-200 rounded-lg px-3 py-2">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span class="text-sm font-semibold text-slate-800">${p.nama}</span>
                    </div>
                    <span class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">Kembali: ${p.kembali ?? '—'}</span>
                </li>
            `;
        });

        document.getElementById('modalBukuDipinjam').classList.remove('hidden');
        document.getElementById('btnHapusTetap').onclick = () => form.submit();
    } else {
        // Buku aman dihapus
        document.getElementById('modalKonfirmasiHapus').classList.remove('hidden');
        document.getElementById('btnKonfirmasiHapus').onclick = () => form.submit();
    }
}

// Tutup modal jika klik di luar area
['modalBukuDipinjam', 'modalKonfirmasiHapus'].forEach(id => {
    document.getElementById(id).addEventListener('click', e => {
        if (e.target === e.currentTarget) e.currentTarget.classList.add('hidden');
    });
});
</script>
@endsection

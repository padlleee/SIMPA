@extends('layouts.app')

@section('title', 'Peminjaman Multi-Buku')
@section('page-title', 'Peminjaman Multi-Buku')
@section('page-subtitle', 'Pinjamkan beberapa buku sekaligus kepada satu peminjam')

@section('content')
<div class="max-w-4xl">

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4 mb-5">
        <p class="text-sm font-semibold text-red-700 mb-1">Terdapat kesalahan:</p>
        <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form id="multiPinjamForm" action="{{ route('peminjaman.multi.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- CARD 1: Data Peminjam --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-7">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-5">Data Peminjam</h3>
            <div class="grid md:grid-cols-3 gap-5">
                <div class="md:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Peminjam <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}"
                           placeholder="Nama lengkap peminjam"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_peminjam') border-red-400 @enderror">
                    @error('nama_peminjam')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tanggal_pinjam') border-red-400 @enderror">
                    @error('tanggal_pinjam')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Batas Kembali <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                           value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tanggal_kembali') border-red-400 @enderror">
                    @error('tanggal_kembali')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Alert tanggal --}}
            <div id="dateAlert" class="hidden mt-4">
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p id="dateAlertMsg" class="text-sm text-red-700 font-medium"></p>
                </div>
            </div>
        </div>

        {{-- CARD 2: Pilih Buku --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest">Pilih Buku</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Hanya menampilkan buku yang masih tersedia stoknya</p>
                </div>
                <span id="badgeJumlah" class="bg-slate-800 text-white text-xs font-bold px-3 py-1 rounded-full">0 dipilih</span>
            </div>

            {{-- Search filter --}}
            <div class="px-7 py-4 border-b border-slate-100">
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="searchBuku" placeholder="Cari judul atau pengarang..."
                           class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
            </div>

            {{-- Daftar buku --}}
            <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto" id="daftarBuku">
                @forelse($bukuTersedia as $buku)
                @php $tersedia = $buku->jumlah_buku - $buku->dipinjam_count; @endphp
                <label class="buku-item flex items-center gap-4 px-7 py-4 hover:bg-slate-50 cursor-pointer transition-colors has-[:checked]:bg-slate-50 has-[:checked]:border-l-2 has-[:checked]:border-l-slate-800"
                       data-judul="{{ strtolower($buku->judul_buku) }}" data-pengarang="{{ strtolower($buku->pengarang) }}">
                    <input type="checkbox" name="buku_ids[]" value="{{ $buku->id_buku }}"
                           class="w-4 h-4 rounded border-slate-300 text-slate-800 focus:ring-slate-800 shrink-0"
                           {{ (is_array(old('buku_ids')) && in_array($buku->id_buku, old('buku_ids'))) || $preselected == $buku->id_buku ? 'checked' : '' }}
                           onchange="updateBadge()">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $buku->judul_buku }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $buku->pengarang }}
                            @if($buku->kategori_buku) · <span class="text-blue-500">{{ $buku->kategori_buku }}</span>@endif
                        </p>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="font-mono text-xs text-slate-400">{{ $buku->kode_buku }}</span>
                        <p class="text-xs font-semibold mt-0.5 {{ $tersedia <= 2 ? 'text-amber-600' : 'text-green-600' }}">
                            {{ $tersedia }} tersedia
                        </p>
                    </div>
                </label>
                @empty
                <div class="px-7 py-12 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                    <p class="font-medium text-sm">Tidak ada buku yang tersedia saat ini</p>
                    <p class="text-xs mt-1">Semua buku sedang dipinjam</p>
                </div>
                @endforelse
            </div>

            {{-- No result search --}}
            <div id="noSearchResult" class="hidden px-7 py-8 text-center text-slate-400 text-sm">
                Tidak ada buku yang cocok dengan pencarian.
            </div>

            @error('buku_ids')
            <div class="px-7 py-3 bg-red-50 border-t border-red-100">
                <p class="text-red-500 text-sm">{{ $message }}</p>
            </div>
            @enderror
        </div>

        {{-- Summary + Submit --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm px-7 py-5 flex items-center justify-between gap-4">
            <div id="summaryText" class="text-sm text-slate-500">Belum ada buku yang dipilih.</div>
            <div class="flex gap-3 shrink-0">
                <a href="{{ route('perpustakaan.index') }}" class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" id="submitBtn" class="bg-slate-800 text-white px-8 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Pinjamkan Semua
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// ===================== TANGGAL =====================
const tglPinjam   = document.getElementById('tanggal_pinjam');
const tglKembali  = document.getElementById('tanggal_kembali');
const dateAlert   = document.getElementById('dateAlert');
const dateAlertMsg = document.getElementById('dateAlertMsg');
const submitBtn   = document.getElementById('submitBtn');

function validateDates() {
    const p = new Date(tglPinjam.value);
    const k = new Date(tglKembali.value);
    if (!tglPinjam.value || !tglKembali.value) return;
    if (p >= k) {
        dateAlertMsg.textContent = p.getTime() === k.getTime()
            ? 'Batas kembali tidak boleh sama dengan tanggal pinjam.'
            : 'Batas kembali tidak boleh lebih awal dari tanggal pinjam.';
        dateAlert.classList.remove('hidden');
        submitBtn.disabled = true;
    } else {
        dateAlert.classList.add('hidden');
        submitBtn.disabled = false;
    }
}
tglPinjam.addEventListener('change', validateDates);
tglKembali.addEventListener('change', validateDates);
validateDates();

// ===================== BADGE & SUMMARY =====================
function updateBadge() {
    const checked = document.querySelectorAll('input[name="buku_ids[]"]:checked');
    const badge   = document.getElementById('badgeJumlah');
    const summary = document.getElementById('summaryText');

    badge.textContent = checked.length + ' dipilih';

    if (checked.length === 0) {
        summary.textContent = 'Belum ada buku yang dipilih.';
        badge.className = 'bg-slate-300 text-white text-xs font-bold px-3 py-1 rounded-full';
    } else {
        const titles = Array.from(checked).map(el => {
            return el.closest('label').querySelector('p.font-semibold').textContent.trim();
        });
        summary.innerHTML = '<span class="font-semibold text-slate-700">' + checked.length + ' buku</span> akan dipinjamkan: ' + titles.slice(0, 3).join(', ') + (titles.length > 3 ? ` dan ${titles.length - 3} lainnya.` : '.');
        badge.className = 'bg-slate-800 text-white text-xs font-bold px-3 py-1 rounded-full';
    }
}
updateBadge();

// ===================== SEARCH =====================
document.getElementById('searchBuku').addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    const items = document.querySelectorAll('.buku-item');
    let visible = 0;
    items.forEach(item => {
        const match = item.dataset.judul.includes(q) || item.dataset.pengarang.includes(q);
        item.classList.toggle('hidden', !match);
        if (match) visible++;
    });
    document.getElementById('noSearchResult').classList.toggle('hidden', visible > 0 || q === '');
});

// Double-check saat submit
document.getElementById('multiPinjamForm').addEventListener('submit', function(e) {
    const p = new Date(tglPinjam.value);
    const k = new Date(tglKembali.value);
    if (p >= k) { e.preventDefault(); validateDates(); return; }

    const checked = document.querySelectorAll('input[name="buku_ids[]"]:checked');
    if (checked.length === 0) {
        e.preventDefault();
        alert('Pilih minimal satu buku terlebih dahulu.');
    }
});
</script>
@endsection

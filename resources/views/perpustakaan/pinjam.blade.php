@extends('layouts.app')

@section('title', 'Pinjamkan Buku')
@section('page-title', 'Form Peminjaman')
@section('page-subtitle', 'Pinjamkan buku kepada anggota')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <div class="bg-slate-50 rounded-xl p-5 mb-6">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Buku yang Dipinjamkan</p>
        <p class="font-bold text-slate-800 text-lg">{{ $perpustakaan->judul_buku }}</p>
        <p class="text-slate-500 text-sm">{{ $perpustakaan->pengarang }} · {{ $perpustakaan->kode_buku }}</p>
    </div>

    <form id="pinjamForm" action="{{ route('perpustakaan.pinjam.store', $perpustakaan) }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Tipe Peminjam <span class="text-red-500">*</span></label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="tipe_peminjam" value="Anak Asuh" class="w-4 h-4 text-slate-800" onchange="togglePeminjamInputs()" {{ old('tipe_peminjam') == 'Anak Asuh' ? 'checked' : '' }}>
                    <span class="text-sm text-slate-700">Anak Asuh</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="tipe_peminjam" value="Donatur" class="w-4 h-4 text-slate-800" onchange="togglePeminjamInputs()" {{ old('tipe_peminjam') == 'Donatur' ? 'checked' : '' }}>
                    <span class="text-sm text-slate-700">Donatur</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="tipe_peminjam" value="Umum" class="w-4 h-4 text-slate-800" onchange="togglePeminjamInputs()" {{ old('tipe_peminjam', 'Umum') == 'Umum' ? 'checked' : '' }}>
                    <span class="text-sm text-slate-700">Umum</span>
                </label>
            </div>
            @error('tipe_peminjam')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div id="input_anak_asuh" class="hidden">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Anak Asuh <span class="text-red-500">*</span></label>
            <select name="id_anak_asuh" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('id_anak_asuh') border-red-400 @enderror">
                <option value="">Pilih Anak Asuh</option>
                @foreach($anakAsuh as $anak)
                    <option value="{{ $anak->id_anak }}" {{ old('id_anak_asuh') == $anak->id_anak ? 'selected' : '' }}>{{ $anak->nama_anak }}</option>
                @endforeach
            </select>
            @error('id_anak_asuh')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div id="input_donatur" class="hidden">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Donatur <span class="text-red-500">*</span></label>
            <select name="id_donatur" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('id_donatur') border-red-400 @enderror">
                <option value="">Pilih Donatur</option>
                @foreach($donatur as $don)
                    <option value="{{ $don->id_donatur }}" {{ old('id_donatur') == $don->id_donatur ? 'selected' : '' }}>{{ $don->nama_donatur }}</option>
                @endforeach
            </select>
            @error('id_donatur')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div id="input_umum">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Peminjam Umum <span class="text-red-500">*</span></label>
            <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_peminjam') border-red-400 @enderror"
                   placeholder="Nama lengkap peminjam umum">
            @error('nama_peminjam')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tanggal_pinjam') border-red-400 @enderror">
                @error('tanggal_pinjam')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Batas Kembali <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                       value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tanggal_kembali') border-red-400 @enderror">
                @error('tanggal_kembali')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Alert: tanggal sama atau batas kembali lebih awal --}}
        <div id="dateAlert" class="hidden">
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p id="dateAlertMsg" class="text-sm text-red-700 font-medium"></p>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" id="submitBtn" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Pinjamkan</button>
            <a href="{{ route('perpustakaan.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

<script>
const tglPinjam   = document.getElementById('tanggal_pinjam');
const tglKembali  = document.getElementById('tanggal_kembali');
const dateAlert   = document.getElementById('dateAlert');
const dateAlertMsg = document.getElementById('dateAlertMsg');
const submitBtn   = document.getElementById('submitBtn');

function validateDates() {
    const pinjam  = tglPinjam.value;
    const kembali = tglKembali.value;

    if (!pinjam || !kembali) {
        dateAlert.classList.add('hidden');
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        return;
    }

    const p = new Date(pinjam);
    const k = new Date(kembali);

    if (p >= k) {
        // Tanggal sama atau kembali lebih awal
        if (p.getTime() === k.getTime()) {
            dateAlertMsg.textContent = 'Batas kembali tidak boleh sama dengan tanggal pinjam. Harap pilih tanggal kembali yang lebih lambat.';
        } else {
            dateAlertMsg.textContent = 'Batas kembali tidak boleh lebih awal dari tanggal pinjam. Harap periksa kembali.';
        }
        dateAlert.classList.remove('hidden');
        tglKembali.classList.add('border-red-400');
        tglKembali.classList.remove('border-slate-300');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        dateAlert.classList.add('hidden');
        tglKembali.classList.remove('border-red-400');
        tglKembali.classList.add('border-slate-300');
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

tglPinjam.addEventListener('change', validateDates);
tglKembali.addEventListener('change', validateDates);

// Validasi saat submit (double-check)
document.getElementById('pinjamForm').addEventListener('submit', function(e) {
    const p = new Date(tglPinjam.value);
    const k = new Date(tglKembali.value);
    if (p >= k) {
        e.preventDefault();
        validateDates();
    }
});

function togglePeminjamInputs() {
    const tipe = document.querySelector('input[name="tipe_peminjam"]:checked').value;
    document.getElementById('input_anak_asuh').classList.toggle('hidden', tipe !== 'Anak Asuh');
    document.getElementById('input_donatur').classList.toggle('hidden', tipe !== 'Donatur');
    document.getElementById('input_umum').classList.toggle('hidden', tipe !== 'Umum');
}

// Run on page load (handles old() values)
validateDates();
togglePeminjamInputs();
</script>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')
@section('page-subtitle', 'Daftarkan koleksi buku baru')

@section('content')
<div class="max-w-3xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('perpustakaan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- SECTION: Identitas --}}
        <div>
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Identitas Buku</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_buku" value="{{ old('kode_buku', $newKodeBuku ?? '') }}" readonly
                           class="w-full border border-slate-300 bg-slate-50 text-slate-500 rounded-xl px-4 py-3 focus:outline-none cursor-not-allowed @error('kode_buku') border-red-400 @enderror">
                    @error('kode_buku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Eksemplar <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_buku" value="{{ old('jumlah_buku', 1) }}" min="1"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_buku" value="{{ old('judul_buku') }}" placeholder="Masukkan judul buku"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('judul_buku') border-red-400 @enderror">
                    @error('judul_buku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pengarang / Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="pengarang" value="{{ old('pengarang') }}" placeholder="Nama pengarang"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('pengarang') border-red-400 @enderror">
                    @error('pengarang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" placeholder="cth: 2022" min="1900" max="{{ date('Y') }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="cth: 978-623-xxx-xxx-x"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori / Genre</label>
                    <select name="kategori_buku" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="">— Pilih Kategori —</option>
                        @foreach(['Agama & Spiritual','Anak-anak','Biografi','Ensiklopedi','Fiksi','Ilmu Pengetahuan','Kesehatan','Motivasi','Pelajaran Sekolah','Teknologi','Lainnya'] as $kat)
                        <option value="{{ $kat }}" {{ old('kategori_buku') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi Buku</label>
                    <select name="kondisi_buku" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="Baik" {{ old('kondisi_buku', 'Baik') === 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup Baik" {{ old('kondisi_buku') === 'Cukup Baik' ? 'selected' : '' }}>Cukup Baik</option>
                        <option value="Rusak Ringan" {{ old('kondisi_buku') === 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('kondisi_buku') === 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Sinopsis / Deskripsi</label>
                    <textarea name="sinopsis" rows="4" placeholder="Deskripsi singkat tentang buku ini..."
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 resize-none">{{ old('sinopsis') }}</textarea>
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        {{-- SECTION: Foto --}}
        <div>
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Sampul Buku</h3>
            <div class="flex items-start gap-6">
                <div id="coverPreviewWrap" class="w-28 h-36 bg-slate-100 border-2 border-dashed border-slate-300 rounded-xl flex items-center justify-center shrink-0 overflow-hidden">
                    <svg id="coverIcon" class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <img id="coverPreview" class="hidden w-full h-full object-cover" alt="Preview">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Foto Sampul</label>
                    <input type="file" name="foto_buku" id="foto_buku" accept="image/*"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG, WebP. Maks. 2MB. Rasio ideal: 2:3 (potret).</p>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan</button>
            <a href="{{ route('perpustakaan.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

<script>
document.getElementById('foto_buku').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('coverIcon').classList.add('hidden');
        const img = document.getElementById('coverPreview');
        img.src = ev.target.result;
        img.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});
</script>
@endsection

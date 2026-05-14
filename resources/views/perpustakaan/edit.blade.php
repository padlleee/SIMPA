@extends('layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')
@section('page-subtitle', 'Perbarui data koleksi buku')

@section('content')
<div class="max-w-3xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('perpustakaan.update', $perpustakaan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div>
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Identitas Buku</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Buku</label>
                    <input type="text" name="kode_buku" value="{{ old('kode_buku', $perpustakaan->kode_buku) }}" readonly
                           class="w-full border border-slate-300 bg-slate-50 text-slate-500 rounded-xl px-4 py-3 focus:outline-none cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Eksemplar <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_buku" value="{{ old('jumlah_buku', $perpustakaan->jumlah_buku) }}" min="1"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_buku" value="{{ old('judul_buku', $perpustakaan->judul_buku) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('judul_buku') border-red-400 @enderror">
                    @error('judul_buku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pengarang / Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="pengarang" value="{{ old('pengarang', $perpustakaan->pengarang) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit', $perpustakaan->penerbit) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $perpustakaan->tahun_terbit) }}" min="1900" max="{{ date('Y') }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $perpustakaan->isbn) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori / Genre</label>
                    <select name="kategori_buku" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="">— Pilih Kategori —</option>
                        @foreach(['Agama & Spiritual','Anak-anak','Biografi','Ensiklopedi','Fiksi','Ilmu Pengetahuan','Kesehatan','Motivasi','Pelajaran Sekolah','Teknologi','Lainnya'] as $kat)
                        <option value="{{ $kat }}" {{ old('kategori_buku', $perpustakaan->kategori_buku) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi Buku</label>
                    <select name="kondisi_buku" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        @foreach(['Baik','Cukup Baik','Rusak Ringan','Rusak Berat'] as $k)
                        <option value="{{ $k }}" {{ old('kondisi_buku', $perpustakaan->kondisi_buku) === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Sinopsis / Deskripsi</label>
                    <textarea name="sinopsis" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 resize-none">{{ old('sinopsis', $perpustakaan->sinopsis) }}</textarea>
                </div>
            </div>
        </div>

        <hr class="border-slate-100">

        <div>
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-4">Sampul Buku</h3>
            <div class="flex items-start gap-6">
                <div class="w-28 h-36 rounded-xl overflow-hidden border border-slate-200 shrink-0 bg-slate-100 flex items-center justify-center">
                    @if($perpustakaan->foto_buku && file_exists(public_path('storage/' . $perpustakaan->foto_buku)))
                        <img id="coverPreview" src="{{ asset('storage/' . $perpustakaan->foto_buku) }}" class="w-full h-full object-cover" alt="Cover">
                    @else
                        <img id="coverPreview" class="hidden w-full h-full object-cover" alt="Preview">
                        <svg id="coverIcon" class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ganti Foto Sampul</label>
                    <input type="file" name="foto_buku" id="foto_buku" accept="image/*"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <p class="text-xs text-slate-400 mt-2">Biarkan kosong jika tidak ingin mengganti foto. Maks. 2MB.</p>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan Perubahan</button>
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
    reader.onload = ev => {
        const icon = document.getElementById('coverIcon');
        if (icon) icon.classList.add('hidden');
        const img = document.getElementById('coverPreview');
        img.src = ev.target.result;
        img.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});
</script>
@endsection

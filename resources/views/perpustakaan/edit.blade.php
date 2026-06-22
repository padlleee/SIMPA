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
                    <input type="text" name="kode_buku" value="{{ old('kode_buku', $perpustakaan->kode_buku) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Buku <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_buku" value="{{ old('jumlah_buku', $perpustakaan->jumlah_buku) }}" min="1"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('jumlah_buku') border-red-400 @enderror">
                    @error('jumlah_buku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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
                    @php
                        $stdKondisi   = ['Baru', 'Bekas'];
                        $kondisiVal   = old('kondisi_buku', $perpustakaan->kondisi_buku);
                        $isKondisiLain = $kondisiVal && !in_array($kondisiVal, $stdKondisi);
                        $selKondisiVal = $isKondisiLain ? 'Lainnya' : $kondisiVal;
                    @endphp
                    <select name="kondisi_buku" id="kondisi_buku" onchange="toggleKondisiLainnya(this.value)"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="" disabled {{ !$selKondisiVal ? 'selected' : '' }}>Pilih Kondisi</option>
                        <option value="Baru" {{ $selKondisiVal === 'Baru' ? 'selected' : '' }}>Baru</option>
                        <option value="Bekas" {{ $selKondisiVal === 'Bekas' ? 'selected' : '' }}>Bekas</option>
                        <option value="Lainnya" {{ $selKondisiVal === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    <div id="kondisi_lainnya_container" class="mt-3 {{ $selKondisiVal === 'Lainnya' ? '' : 'hidden' }}">
                        <input type="text" id="kondisi_buku_lainnya" name="kondisi_buku_lainnya"
                               value="{{ old('kondisi_buku_lainnya', $isKondisiLain ? $kondisiVal : '') }}"
                               placeholder="Contoh: Rusak Ringan, Seperti Baru..."
                               class="w-full border border-indigo-300 bg-indigo-50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('kondisi_buku_lainnya') border-red-400 @enderror">
                        @error('kondisi_buku_lainnya')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
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

                    {{-- Alert ukuran/tipe gambar --}}
                    <div id="fotoAlert" class="hidden mt-3">
                        <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p id="fotoAlertMsg" class="text-sm text-red-700 font-medium"></p>
                        </div>
                    </div>
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
const MAX_SIZE = 2 * 1024 * 1024; // 2MB
const ALLOWED  = ['image/jpeg','image/png','image/webp','image/gif'];

document.getElementById('foto_buku').addEventListener('change', function(e) {
    const file         = e.target.files[0];
    const alertBox     = document.getElementById('fotoAlert');
    const alertMsg     = document.getElementById('fotoAlertMsg');
    const submitBtn    = document.querySelector('button[type="submit"]');
    const coverPreview = document.getElementById('coverPreview');
    const coverIcon    = document.getElementById('coverIcon');

    // Reset state
    alertBox.classList.add('hidden');
    submitBtn.disabled = false;
    submitBtn.classList.remove('opacity-50','cursor-not-allowed');

    if (!file) return;

    // Cek tipe
    if (!ALLOWED.includes(file.type)) {
        alertMsg.textContent = 'Format file tidak didukung. Gunakan JPG, PNG, atau WebP.';
        alertBox.classList.remove('hidden');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50','cursor-not-allowed');
        e.target.value = '';
        return;
    }

    // Cek ukuran
    if (file.size > MAX_SIZE) {
        const sizeMB = (file.size / 1024 / 1024).toFixed(2);
        alertMsg.textContent = `Ukuran gambar terlalu besar (${sizeMB} MB). Maksimal ukuran file yang diizinkan adalah 2 MB.`;
        alertBox.classList.remove('hidden');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50','cursor-not-allowed');
        e.target.value = '';
        return;
    }

    // OK — tampilkan preview
    const reader = new FileReader();
    reader.onload = ev => {
        if (coverIcon) coverIcon.classList.add('hidden');
        coverPreview.src = ev.target.result;
        coverPreview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});


// Toggle input kondisi lainnya
function toggleKondisiLainnya(value) {
    const container = document.getElementById('kondisi_lainnya_container');
    const input     = document.getElementById('kondisi_buku_lainnya');
    if (value === 'Lainnya') {
        container.classList.remove('hidden');
        input.required = true;
        input.focus();
    } else {
        container.classList.add('hidden');
        input.required = false;
        input.value = '';
    }
}
</script>
@endsection

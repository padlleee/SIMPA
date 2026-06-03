@extends('layouts.app')

@section('title', 'Edit Peralatan')
@section('page-title', 'Edit Data Peralatan')
@section('page-subtitle', 'Ubah detail, lokasi, dan kondisi peralatan')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('inventaris.update', $inventaris) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-5">

            {{-- KATEGORI (Tidak bisa berganti bebas, tapi tetap bisa diubah via dropdown) --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Kategori Peralatan <span class="text-red-500">*</span>
                </label>
                <select id="nama_kategori" name="nama_kategori"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800"
                        onchange="toggleKategoriLainnya(this.value)">
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ old('nama_kategori', $inventaris->nama_kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                    <option value="Lainnya" {{ old('nama_kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <div id="kategori_lainnya_container" class="mt-3 {{ old('nama_kategori') === 'Lainnya' ? '' : 'hidden' }}">
                    <input type="text" id="nama_kategori_lainnya" name="nama_kategori_lainnya"
                           value="{{ old('nama_kategori_lainnya') }}"
                           placeholder="Masukkan nama kategori baru..."
                           class="w-full border border-indigo-300 bg-indigo-50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_kategori_lainnya') border-red-400 @enderror">
                    @error('nama_kategori_lainnya')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                @error('nama_kategori')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- NAMA BARANG SPESIFIK --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Barang Spesifik <span class="text-red-500">*</span>
                    <span class="text-xs text-slate-400 font-normal ml-1">— Nama unik unit ini (contoh: Kulkas Sony 200L)</span>
                </label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang', $inventaris->nama_barang) }}" required
                       placeholder="Contoh: Kulkas Sony 200L, Kipas Angin Panasonic 16 inch..."
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_barang') border-red-400 @enderror">
                @error('nama_barang')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- KODE BARANG --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang', $inventaris->kode_barang) }}" readonly
                       class="w-full border border-slate-300 bg-slate-50 text-slate-500 rounded-xl px-4 py-3 focus:outline-none cursor-not-allowed">
            </div>

            {{-- JUMLAH --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $inventaris->jumlah) }}" min="1" required
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('jumlah') border-red-400 @enderror">
                @error('jumlah')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- SATUAN --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                @php
                    $stdSatuan = ['Unit', 'Buah', 'Set', 'Pasang', 'Lembar', 'Pak', 'Kotak', 'Rol'];
                    $satVal = old('satuan', $inventaris->satuan);
                    $isSatLain = !in_array($satVal, $stdSatuan) && $satVal != '';
                    $selSatVal = $isSatLain ? 'Lainnya' : $satVal;
                @endphp
                <select name="satuan" id="satuan" onchange="toggleSatuanLainnya(this.value)"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('satuan') border-red-400 @enderror">
                    <option value="" disabled {{ !$selSatVal ? 'selected' : '' }}>Pilih Satuan</option>
                    <option value="Unit" {{ $selSatVal === 'Unit' ? 'selected' : '' }}>Unit</option>
                    <option value="Buah" {{ $selSatVal === 'Buah' ? 'selected' : '' }}>Buah</option>
                    <option value="Set" {{ $selSatVal === 'Set' ? 'selected' : '' }}>Set</option>
                    <option value="Pasang" {{ $selSatVal === 'Pasang' ? 'selected' : '' }}>Pasang</option>
                    <option value="Lembar" {{ $selSatVal === 'Lembar' ? 'selected' : '' }}>Lembar</option>
                    <option value="Pak" {{ $selSatVal === 'Pak' ? 'selected' : '' }}>Pak</option>
                    <option value="Kotak" {{ $selSatVal === 'Kotak' ? 'selected' : '' }}>Kotak</option>
                    <option value="Rol" {{ $selSatVal === 'Rol' ? 'selected' : '' }}>Rol</option>
                    <option value="Lainnya" {{ $selSatVal === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <div id="satuan_lainnya_container" class="mt-3 {{ $selSatVal === 'Lainnya' ? '' : 'hidden' }}">
                    <input type="text" id="satuan_lainnya" name="satuan_lainnya"
                           value="{{ old('satuan_lainnya', $isSatLain ? $satVal : '') }}"
                           placeholder="Masukkan satuan baru..."
                           class="w-full border border-indigo-300 bg-indigo-50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('satuan_lainnya') border-red-400 @enderror">
                    @error('satuan_lainnya')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                @error('satuan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- LOKASI --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $inventaris->lokasi) }}" placeholder="Contoh: Kantor, Dapur..." required
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('lokasi') border-red-400 @enderror">
                @error('lokasi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- KONDISI --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi <span class="text-red-500">*</span></label>
                <select name="kondisi" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <option value="Baik"  {{ old('kondisi', $inventaris->kondisi) === 'Baik'  ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak" {{ old('kondisi', $inventaris->kondisi) === 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            {{-- GAMBAR --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar / Foto Kondisi (Opsional)</label>
                @if($inventaris->gambar)
                <div class="mb-3">
                    <img src="{{ Storage::url($inventaris->gambar) }}" alt="Gambar Peralatan"
                         class="w-32 h-32 object-cover rounded-xl border border-slate-200 cursor-zoom-in img-zoom-trigger"
                         data-src="{{ Storage::url($inventaris->gambar) }}">
                </div>
                @endif
                <input type="file" name="gambar" accept="image/*"
                       class="w-full border border-slate-300 rounded-xl px-4 py-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 cursor-pointer focus:outline-none focus:ring-2 focus:ring-slate-800">
                <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                @error('gambar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- KETERANGAN --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" placeholder="Catatan kondisi, spesifikasi, atau informasi tambahan..."
                          class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 resize-none">{{ old('keterangan', $inventaris->keterangan) }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan Perubahan</button>
            <a href="{{ route('inventaris.show', ['nama_kategori' => $inventaris->nama_kategori]) }}"
               class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

@push('scripts')
<script>
    function toggleKategoriLainnya(value) {
        const container = document.getElementById('kategori_lainnya_container');
        const input     = document.getElementById('nama_kategori_lainnya');
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

    function toggleSatuanLainnya(value) {
        const container = document.getElementById('satuan_lainnya_container');
        const input     = document.getElementById('satuan_lainnya');
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

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('nama_kategori').value === 'Lainnya') {
            document.getElementById('kategori_lainnya_container').classList.remove('hidden');
            document.getElementById('nama_kategori_lainnya').required = true;
        }

        if (document.getElementById('satuan').value === 'Lainnya') {
            document.getElementById('satuan_lainnya_container').classList.remove('hidden');
            document.getElementById('satuan_lainnya').required = true;
        }

        // Zoom gambar
        document.querySelectorAll('.img-zoom-trigger').forEach(function(img) {
            img.addEventListener('click', function() {
                openImgZoom(this.dataset.src || this.src);
            });
        });
    });

    function openImgZoom(src) {
        const modal = document.getElementById('imgZoomModal');
        if (!modal) return;
        document.getElementById('imgZoomContent').src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
</script>
@endpush
@endsection

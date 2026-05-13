@extends('layouts.app')

@section('title', 'Edit Anak Asuh')
@section('page-title', 'Edit Anak Asuh')
@section('page-subtitle', 'Perbarui data anak asuh')

@section('content')
<div class="max-w-4xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('anak-asuh.update', $anakAsuh) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div>
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">Informasi Dasar</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_anak" value="{{ old('nama_anak', $anakAsuh->nama_anak) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_anak') border-red-400 @enderror">
                    @error('nama_anak')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $anakAsuh->tempat_lahir) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tempat_lahir') border-red-400 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anakAsuh->tanggal_lahir?->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tanggal_lahir') border-red-400 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="L" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pendidikan</label>
                    <select name="pendidikan" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="">Pilih Pendidikan...</option>
                        <option value="TK" {{ old('pendidikan', $anakAsuh->pendidikan) === 'TK' ? 'selected' : '' }}>TK</option>
                        <option value="SD" {{ old('pendidikan', $anakAsuh->pendidikan) === 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('pendidikan', $anakAsuh->pendidikan) === 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA/SMK" {{ old('pendidikan', $anakAsuh->pendidikan) === 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                        <option value="Kuliah" {{ old('pendidikan', $anakAsuh->pendidikan) === 'Kuliah' ? 'selected' : '' }}>Kuliah / Perguruan Tinggi</option>
                        <option value="Tidak/Belum Sekolah" {{ old('pendidikan', $anakAsuh->pendidikan) === 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas / Tingkat</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $anakAsuh->kelas) }}" placeholder="cth: Kelas 1 / Semester 3"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Layanan</label>
                    <input type="text" name="jenis_layanan" value="{{ old('jenis_layanan', $anakAsuh->jenis_layanan) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">Alamat Lengkap</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dusun / Jalan</label>
                    <input type="text" name="dusun" value="{{ old('dusun', $anakAsuh->dusun) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">RT</label>
                        <input type="text" name="rt" value="{{ old('rt', $anakAsuh->rt) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">RW</label>
                        <input type="text" name="rw" value="{{ old('rw', $anakAsuh->rw) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Desa / Kelurahan</label>
                    <input type="text" name="desa" value="{{ old('desa', $anakAsuh->desa) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $anakAsuh->kecamatan) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">Status & Akademik</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status_anak" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="Aktif" {{ old('status_anak', $anakAsuh->status_anak) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Alumni" {{ old('status_anak', $anakAsuh->status_anak) === 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $anakAsuh->tanggal_masuk?->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Perkembangan Akademik</label>
                    <textarea name="perkembangan_akademik" rows="2"
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">{{ old('perkembangan_akademik', $anakAsuh->perkembangan_akademik) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Kesehatan</label>
                    <textarea name="catatan_kesehatan" rows="2"
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">{{ old('catatan_kesehatan', $anakAsuh->catatan_kesehatan) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Perbarui Data</button>
            <a href="{{ route('anak-asuh.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection

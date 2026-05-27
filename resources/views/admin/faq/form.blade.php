@extends('layouts.app')

@section('title', $faq ? 'Edit FAQ' : 'Tambah FAQ')
@section('page-title', $faq ? 'Edit FAQ' : 'Tambah FAQ Baru')
@section('page-subtitle', $faq ? 'Perbarui informasi pertanyaan dan jawaban' : 'Tambahkan pertanyaan yang sering diajukan beserta jawabannya')

@section('content')

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ $faq ? route('admin.faq.update', $faq->id) : route('admin.faq.store') }}" method="POST">
            @csrf
            @if($faq)
                @method('PUT')
            @endif

            <div class="p-6 md:p-8 space-y-6">
                {{-- Kategori & Urutan --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-2">
                            Kategori FAQ <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="kategori" required
                                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('kategori') border-red-400 @enderror">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($labels as $key => $label)
                                <option value="{{ $key }}" {{ old('kategori', $faq->kategori ?? '') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="urutan" class="block text-sm font-semibold text-slate-700 mb-2">
                            Urutan
                        </label>
                        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $faq->urutan ?? 0) }}" min="0" max="999"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('urutan') border-red-400 @enderror">
                        <p class="text-xs text-slate-400 mt-1">Lebih kecil = lebih atas</p>
                        @error('urutan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Pertanyaan --}}
                <div>
                    <label for="pertanyaan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="pertanyaan" id="pertanyaan" value="{{ old('pertanyaan', $faq->pertanyaan ?? '') }}" required
                           placeholder="Contoh: Bagaimana cara berdonasi?"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('pertanyaan') border-red-400 @enderror">
                    @error('pertanyaan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jawaban --}}
                <div>
                    <label for="jawaban" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jawaban <span class="text-red-500">*</span>
                    </label>
                    <textarea name="jawaban" id="jawaban" rows="6" required
                              placeholder="Masukkan jawaban yang jelas dan informatif..."
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('jawaban') border-red-400 @enderror">{{ old('jawaban', $faq->jawaban ?? '') }}</textarea>
                    @error('jawaban')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-slate-50 border-t border-slate-200 px-6 py-5 flex items-center gap-3">
                <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">
                    {{ $faq ? 'Simpan Perubahan' : 'Simpan FAQ' }}
                </button>
                <a href="{{ route('admin.faq.index') }}" class="bg-white border border-slate-300 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

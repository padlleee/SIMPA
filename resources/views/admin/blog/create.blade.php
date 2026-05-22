@extends('layouts.app')

@section('title', 'Tulis Artikel Baru')
@section('page-title', 'Tulis Artikel Baru')
@section('page-subtitle', 'Publikasikan dokumentasi kegiatan atau berita yayasan')

@section('content')

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-semibold text-slate-700">Form Artikel Baru</h2>
        </div>

        <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            {{-- Title --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5">Judul Artikel <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       oninput="generateSlugPreview(this.value)"
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 @error('title') border-red-400 @enderror"
                       placeholder="Judul artikel...">
                <p id="slug-preview" class="text-xs text-slate-400 mt-1"></p>
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5">Foto / Gambar Utama</label>
                <input type="file" name="image" id="image" accept="image/*"
                       onchange="previewImage(this)"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition-colors @error('image') border-red-400 @enderror">
                <div id="img-preview" class="hidden mt-3">
                    <img id="img-preview-src" src="#" alt="Preview" class="h-40 object-cover rounded-xl border border-slate-200">
                </div>
                <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, WebP. Maks 3 MB.</p>
                @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Content --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5">Isi Artikel <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="14" required
                          class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-slate-400 resize-y @error('content') border-red-400 @enderror"
                          placeholder="Tulis isi artikel di sini...">{{ old('content') }}</textarea>
                @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-slate-800 text-white px-8 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-700 transition-colors">
                    Publikasikan Artikel
                </button>
                <a href="{{ route('admin.blog.index') }}"
                   class="bg-slate-100 text-slate-700 px-8 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function generateSlugPreview(title) {
    const slug = title.toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .trim()
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    const preview = document.getElementById('slug-preview');
    preview.textContent = slug ? 'URL: /blog/' + slug + '-xxxxx' : '';
}

function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const img     = document.getElementById('img-preview-src');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                {{-- Published Date --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5">Tanggal Publikasi</label>
                    <input type="date" name="published_date" id="published_date" value="{{ old('published_date', date('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 @error('published_date') border-red-400 @enderror">
                    <p class="text-xs text-slate-400 mt-1">Biarkan default untuk hari ini.</p>
                    @error('published_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
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
                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                <trix-editor input="content" class="prose max-w-none focus:outline-none focus:ring-1 focus:ring-slate-400 bg-white border border-slate-300 rounded-xl px-4 py-3 min-h-[300px]"></trix-editor>
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

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    /* trix-toolbar file-tools is now enabled for document attachments */
    trix-editor figure.attachment {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }
    trix-editor figcaption.attachment__caption {
        text-align: center;
        font-style: italic;
        color: #64748b; /* slate-500 */
    }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
// Customize Trix Caption Placeholder
Trix.config.lang.captionPlaceholder = "Tulis keterangan foto di sini (atau kosongkan untuk menghapus)...";

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

// Trix Editor Inline Image Upload Handler
document.addEventListener("trix-attachment-add", function(event) {
    if (event.attachment.file) {
        uploadFileAttachment(event.attachment);
    }
});

function uploadFileAttachment(attachment) {
    uploadFile(attachment.file, setProgress, setAttributes);

    function setProgress(progress) {
        attachment.setUploadProgress(progress);
    }

    function setAttributes(attributes) {
        attachment.setAttributes(attributes);
    }
}

function uploadFile(file, progressCallback, successCallback) {
    var formData = new FormData();
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    formData.append("file", file);
    formData.append("_token", csrfToken);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "{{ route('admin.blog.upload-inline-image') }}", true);

    xhr.upload.addEventListener("progress", function(event) {
        var progress = event.loaded / event.total * 100;
        progressCallback(progress);
    });

    xhr.addEventListener("load", function(event) {
        if (xhr.status >= 200 && xhr.status < 300) {
            var response = JSON.parse(xhr.responseText);
            successCallback({
                url: response.url,
                href: response.url
            });
        } else {
            console.error("Upload failed", xhr.responseText);
        }
    });

    xhr.send(formData);
}

// Trix Editor YouTube Embed Button & Handler
function injectYouTubeButton(event) {
    var toolbar = event ? event.target.toolbarElement : document.querySelector("trix-toolbar");
    if (toolbar) {
        var blockGroup = toolbar.querySelector("[data-trix-button-group='block-tools']");
        if (blockGroup && !toolbar.querySelector("#embed-youtube-btn")) {
            var buttonHTML = '<button type="button" class="trix-button" id="embed-youtube-btn" title="Embed YouTube Video" tabindex="-1">📺 Video</button>';
            blockGroup.insertAdjacentHTML("beforeend", buttonHTML);
        }
    }
}

document.addEventListener("trix-initialize", injectYouTubeButton);
// Panggil langsung jika trix sudah terinisialisasi lebih dulu
setTimeout(injectYouTubeButton, 100);

document.addEventListener("click", function(event) {
    if (event.target && event.target.id === "embed-youtube-btn") {
        event.preventDefault();
        var url = prompt("Masukkan URL Video YouTube (contoh: https://www.youtube.com/watch?v=...):");
        if (url) {
            var videoId = extractYouTubeId(url);
            if (videoId) {
                var iframeHtml = '<div class="video-container"><iframe src="https://www.youtube.com/embed/' + videoId + '" allowfullscreen></iframe></div>';
                var attachment = new Trix.Attachment({
                    content: iframeHtml,
                    contentType: "application/vnd.trix.youtube.html"
                });
                
                var trixEditor = document.querySelector("trix-editor");
                trixEditor.editor.insertAttachment(attachment);
                trixEditor.editor.insertString("\n");
            } else {
                alert("URL YouTube tidak valid!");
            }
        }
    }
});

function extractYouTubeId(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}
</script>
@endpush

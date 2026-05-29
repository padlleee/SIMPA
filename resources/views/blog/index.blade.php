@extends('layouts.master')

@section('title', 'Blog & Kegiatan')
@section('meta-description', 'Berita dan dokumentasi kegiatan terkini Yayasan Panti Asuhan Amaliya Subang.')
@section('body-class', 'bg-white text-slate-800')

@section('body')
@include('layouts.navbar')

{{-- HEADER --}}
<section class="pt-32 pb-10 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <span class="inline-block text-xs font-semibold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-5">Blog & Kegiatan</span>
        <h1 class="text-4xl font-bold text-slate-800 mb-4">Dokumentasi & Berita Terkini</h1>
        <p class="text-slate-500 max-w-xl mx-auto">Liputan kegiatan, program pembinaan, renovasi, dan momen bermakna bersama anak-anak asuh Yayasan Amaliya.</p>
    </div>
</section>

{{-- FEATURED POST + ARTICLE GRID --}}
<section class="pb-20">
    <div class="max-w-6xl mx-auto px-6">

        @if($articles->count())

        {{-- Featured Post (artikel pertama) --}}
        @php $featured = $articles->first(); @endphp
        <div class="relative mb-10" id="blog-featured-wrap">
            <a href="{{ route('blog.show', $featured->slug) }}" class="featured-post block" id="blog-featured-link">
                @if($featured->image)
                    <img src="{{ asset('storage/' . $featured->image) }}"
                         alt="{{ $featured->title }}"
                         class="featured-post-img w-full"
                         id="blog-featured-img">
                @else
                    <div class="featured-post-placeholder" id="blog-featured-img"></div>
                @endif
                <div class="featured-post-content">
                    <span class="featured-post-label">Artikel Terbaru</span>
                    <h2 class="featured-post-title" id="blog-featured-title">{{ $featured->title }}</h2>
                    <p class="featured-post-meta" id="blog-featured-meta">
                        {{ $featured->created_at->locale('id')->translatedFormat('j F Y') }}
                        @if($featured->author) · {{ $featured->author->username }} @endif
                        &nbsp;·&nbsp;
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Baca Selengkapnya
                        </span>
                    </p>
                </div>
            </a>

            {{-- Chevron Prev --}}
            @if($articles->count() > 1)
            <button class="featured-nav-btn prev" onclick="blogFeaturedNav(-1)" aria-label="Artikel sebelumnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            {{-- Chevron Next --}}
            <button class="featured-nav-btn next" onclick="blogFeaturedNav(1)" aria-label="Artikel berikutnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Dot indicators --}}
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                @foreach($articles as $i => $a)
                    <button onclick="blogFeaturedGoTo({{ $i }})"
                            class="h-2 rounded-full transition-all bg-white/40 hover:bg-white/80 {{ $i === 0 ? '!bg-white w-6' : 'w-2' }}"
                            id="blog-dot-{{ $i }}"></button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Rest of Articles Grid --}}
        @if($articles->count() > 1)
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-5">Semua Artikel</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles->skip(1) as $article)
                <a href="{{ route('blog.show', $article->slug) }}"
                   class="group bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    {{-- Image --}}
                    <div class="w-full h-44 bg-slate-100 overflow-hidden relative">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    {{-- Content --}}
                    <div class="p-5">
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $article->created_at->locale('id')->translatedFormat('j F Y') }}
                            @if($article->author)
                                <span>·</span>
                                <span>{{ $article->author->username }}</span>
                            @endif
                        </div>
                        <h2 class="font-bold text-slate-800 text-base mb-2 leading-snug group-hover:text-slate-600 transition-colors line-clamp-2">
                            {{ $article->title }}
                        </h2>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-2">{{ $article->excerpt }}</p>
                        <div class="mt-4 text-xs font-semibold text-slate-600 group-hover:text-slate-800 flex items-center gap-1 transition-colors">
                            Baca Selengkapnya
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Pagination --}}
        @if($articles->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $articles->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-24 text-slate-400">
            <div class="text-6xl mb-4">📝</div>
            <p class="font-semibold text-slate-500 text-lg">Belum ada artikel yang dipublikasikan</p>
            <p class="text-sm mt-2">Konten akan segera hadir. Pantau terus!</p>
        </div>
        @endif
    </div>
</section>

@include('layouts.footer')
@endsection

@if($articles->count() > 1)
@push('scripts')
<script>
    @php
        $bpData = $articles->map(function($a) {
            return [
                'title'  => $a->title,
                'url'    => route('blog.show', $a->slug),
                'image'  => $a->image ? asset('storage/' . $a->image) : null,
                'date'   => $a->created_at->locale('id')->translatedFormat('j F Y'),
                'author' => optional($a->author)->username,
            ];
        })->values();
    @endphp
    const blogPosts = {!! json_encode($bpData) !!};
    let blogFeaturedIdx = 0;

    function blogFeaturedNav(dir) {
        blogFeaturedGoTo((blogFeaturedIdx + dir + blogPosts.length) % blogPosts.length);
    }

    function blogFeaturedGoTo(idx) {
        blogFeaturedIdx = idx;
        const p = blogPosts[idx];
        const link  = document.getElementById('blog-featured-link');
        const imgEl = document.getElementById('blog-featured-img');
        const title = document.getElementById('blog-featured-title');
        const meta  = document.getElementById('blog-featured-meta');

        if (link)  link.href = p.url;
        if (title) title.textContent = p.title;
        if (meta)  meta.textContent  = p.date + (p.author ? ' · ' + p.author : '');
        if (imgEl && p.image) {
            imgEl.src = p.image;
            imgEl.alt = p.title;
        }

        document.querySelectorAll('[id^="blog-dot-"]').forEach(function(dot, i) {
            if (i === idx) {
                dot.style.width = '24px';
                dot.style.background = 'rgba(255,255,255,0.9)';
            } else {
                dot.style.width = '8px';
                dot.style.background = 'rgba(255,255,255,0.35)';
            }
        });
    }
</script>
@endpush
@endif

@extends('layouts.master')

@section('title', $article->title)
@section('meta-description', $article->excerpt)
@section('body-class', 'bg-white text-slate-800')

@section('body')
@include('layouts.navbar')

{{-- ARTICLE HERO IMAGE --}}
@if($article->image)
<div class="pt-20 w-full h-80 md:h-[420px] overflow-hidden relative">
    <img src="{{ asset('storage/' . $article->image) }}"
         alt="{{ $article->title }}"
         class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-white/80 to-transparent"></div>
</div>
@else
<div class="pt-20"></div>
@endif

{{-- ARTICLE CONTENT --}}
<article class="max-w-3xl mx-auto px-6 py-12">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8">
        <a href="{{ route('landing') }}" class="hover:text-slate-600">Beranda</a>
        <span>/</span>
        <a href="{{ route('blog.index') }}" class="hover:text-slate-600">Blog</a>
        <span>/</span>
        <span class="text-slate-600 truncate max-w-[200px]">{{ $article->title }}</span>
    </nav>

    {{-- Meta --}}
    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400 mb-5">
        <span class="flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $article->created_at->locale('id')->translatedFormat('j F Y') }}
        </span>
        @if($article->author)
        <span>·</span>
        <span class="flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            {{ $article->author->username }}
        </span>
        @endif
    </div>

    {{-- Title --}}
    <h1 class="text-3xl md:text-4xl font-bold text-slate-800 leading-tight mb-8">{{ $article->title }}</h1>

    {{-- Body --}}
    <div class="prose prose-slate lg:prose-lg max-w-none text-slate-700 leading-relaxed text-[15px]
                prose-headings:font-bold prose-headings:text-slate-800
                prose-p:mb-4 prose-img:rounded-xl prose-a:text-slate-700 prose-a:underline">
        {!! $article->content !!}
    </div>

    {{-- Prev / Next Navigation --}}
    <nav class="mt-12 pt-8 border-t border-slate-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Previous Article --}}
            @if($previous)
            <a href="{{ route('blog.show', $previous->slug) }}"
               class="group flex flex-col gap-1 p-5 rounded-2xl border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all duration-200">
                <span class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 group-hover:text-slate-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Artikel Sebelumnya
                </span>
                <span class="font-semibold text-slate-700 text-sm leading-snug line-clamp-2 group-hover:text-slate-900 transition-colors">
                    {{ $previous->title }}
                </span>
            </a>
            @else
            <div></div>
            @endif

            {{-- Next Article --}}
            @if($next)
            <a href="{{ route('blog.show', $next->slug) }}"
               class="group flex flex-col gap-1 p-5 rounded-2xl border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all duration-200 sm:text-right sm:items-end">
                <span class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 group-hover:text-slate-600 transition-colors sm:flex-row-reverse">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    Artikel Selanjutnya
                </span>
                <span class="font-semibold text-slate-700 text-sm leading-snug line-clamp-2 group-hover:text-slate-900 transition-colors">
                    {{ $next->title }}
                </span>
            </a>
            @endif
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('blog.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Lihat Semua Artikel
            </a>
        </div>
    </nav>
</article>

<style>
/* Aspect Ratio Box untuk Embed YouTube Trix */
.video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    width: 100%;
    overflow: hidden;
    margin: 1.5rem 0;
    border-radius: 0.75rem;
    background: #0F172A;
}
.video-container iframe,
.video-container object,
.video-container embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

/* Trix Figure & Caption Styles */
.prose figure {
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}
.prose figcaption {
    margin-left: auto;
    margin-right: auto;
    text-align: center;
    font-style: italic;
    color: #64748b; /* text-slate-500 */
    font-size: 0.875rem; /* text-sm */
    margin-top: 0.75rem;
}
/* Gracefully handle empty captions */
.prose figcaption:empty {
    display: none;
    margin-top: 0;
}

/* Trix File Attachment Styling (Download Button) */
.prose a:has(.attachment--file) {
    text-decoration: none;
}
.prose .attachment--file {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border: 1px solid #e2e8f0; /* border-slate-200 */
    border-radius: 9999px; /* fully rounded like a pill/bar */
    background-color: #ffffff;
    text-decoration: none;
    margin: 1.5rem 0;
    max-width: 100%;
    width: auto;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
}
.prose .attachment--file:hover {
    border-color: #cbd5e1;
    background-color: #f8fafc;
}
.prose .attachment--file .attachment__caption {
    margin: 0;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    text-align: left;
    font-style: normal;
    color: #387B92; /* The exact text color from screenshot */
    font-weight: 400;
}
.prose .attachment--file .attachment__name {
    font-size: 0.95rem;
    word-break: break-all;
    margin-right: 1rem;
}
.prose .attachment--file .attachment__size {
    display: none; /* Hide size to match screenshot exactly */
}
/* Fake Download Button UI injected via pseudo-element */
.prose .attachment--file .attachment__caption::after {
    content: "Download";
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #387B92; /* Teal-blue color from screenshot */
    color: white;
    padding: 0.6rem 1.5rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    flex-shrink: 0;
}
</style>

@include('layouts.footer')
@endsection

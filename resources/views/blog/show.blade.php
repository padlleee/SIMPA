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
    <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-[15px]
                prose-headings:font-bold prose-headings:text-slate-800
                prose-p:mb-4 prose-img:rounded-xl prose-a:text-slate-700 prose-a:underline">
        {!! nl2br(e($article->content)) !!}
    </div>

    {{-- Back link --}}
    <div class="mt-12 pt-8 border-t border-slate-200">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Blog
        </a>
    </div>
</article>

@include('layouts.footer')
@endsection

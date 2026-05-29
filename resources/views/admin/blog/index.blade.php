@extends('layouts.app')

@section('title', 'Kelola Blog')
@section('page-title', 'Blog & Kegiatan')
@section('page-subtitle', 'Kelola artikel dan dokumentasi kegiatan yayasan')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.blog.create') }}"
       class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tulis Artikel Baru
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="bg-slate-50 border-b border-slate-200 px-5 py-4">
        <h2 class="text-sm font-semibold uppercase text-slate-500">Daftar Artikel ({{ $articles->total() }})</h2>
    </div>

    @if($articles->count())
    <table class="w-full text-sm">
        <thead class="border-b border-slate-100">
            <tr>
                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Judul</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Penulis</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($articles as $article)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <a href="{{ route('blog.show', $article->slug) }}" target="_blank"
                       class="font-semibold text-slate-800 hover:underline line-clamp-1">
                        {{ $article->title }}
                    </a>
                    <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $article->excerpt }}</p>
                </td>
                <td class="px-5 py-4 text-slate-500 hidden md:table-cell">{{ $article->author?->username ?? '—' }}</td>
                <td class="px-5 py-4 text-slate-400 text-xs hidden sm:table-cell whitespace-nowrap">
                    {{ $article->created_at->locale('id')->translatedFormat('j M Y') }}
                </td>
                <td class="px-5 py-4 text-center">
                    <form id="blogDel-{{ $article->id }}" action="{{ route('admin.blog.destroy', $article) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                onclick="simpaConfirm({ title:'Hapus Artikel', message:'Hapus artikel ini? Tindakan tidak dapat diurungkan.', confirmText:'Ya, Hapus', type:'danger', onConfirm:()=>document.getElementById('blogDel-{{ $article->id }}').submit() })"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-semibold transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $articles->links() }}
    </div>
    @else
    <div class="py-16 text-center text-slate-400">
        <div class="text-5xl mb-4">📝</div>
        <p class="font-medium text-slate-500">Belum ada artikel. Mulai tulis sekarang!</p>
    </div>
    @endif
</div>

@endsection

@extends('layouts.app')

@section('title', 'Kelola FAQ')
@section('page-title', 'Kelola FAQ')
@section('page-subtitle', 'Kelola daftar pertanyaan yang sering diajukan beserta jawabannya')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.faq.create') }}"
       class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-slate-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah FAQ Baru
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="bg-slate-50 border-b border-slate-200 px-5 py-4">
        <h2 class="text-sm font-semibold uppercase text-slate-500">Daftar FAQ ({{ $faqs->total() }})</h2>
    </div>

    @if($faqs->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold w-16 text-center">No</th>
                        <th class="px-5 py-4 font-semibold w-32">Kategori</th>
                        <th class="px-5 py-4 font-semibold">Pertanyaan</th>
                        <th class="px-5 py-4 font-semibold w-24 text-center">Urutan</th>
                        <th class="px-5 py-4 font-semibold w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($faqs as $i => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-4 text-center text-slate-400">{{ $faqs->firstItem() + $i }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $kategoriClasses = [
                                        'profil'  => 'bg-slate-100 text-slate-700 border-slate-200',
                                        'donasi'  => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'akun'    => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'layanan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    ];
                                    $class = $kategoriClasses[$item->kategori] ?? 'bg-slate-100 text-slate-700';
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold border {{ $class }}">
                                    {{ $labels[$item->kategori] ?? $item->kategori }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-800 line-clamp-2" title="{{ $item->pertanyaan }}">
                                    {{ $item->pertanyaan }}
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-slate-500 bg-slate-100 px-2 py-1 rounded-md text-xs">{{ $item->urutan }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.faq.edit', $item->id) }}"
                                       class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors"
                                       title="Edit FAQ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.faq.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors"
                                                title="Hapus FAQ">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($faqs->hasPages())
        <div class="px-5 py-4 border-t border-slate-200 bg-slate-50">
            {{ $faqs->links() }}
        </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4 text-3xl">❓</div>
            <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada FAQ</h3>
            <p class="text-slate-500 text-sm max-w-sm mb-6">Anda belum menambahkan pertanyaan dan jawaban (FAQ). Mulai tambahkan sekarang.</p>
            <a href="{{ route('admin.faq.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors">
                Tambah FAQ Pertama
            </a>
        </div>
    @endif
</div>

@endsection

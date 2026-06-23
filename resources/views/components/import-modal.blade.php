{{--
    Komponen Modal Import Excel (Reusable)
    Props:
    - $modalId       : ID unik modal (default: 'importModal')
    - $importRoute   : nama route untuk POST import
    - $templateRoute : nama route untuk GET download template
    - $title         : judul modal
    - $columns       : array string kolom yang diterima
--}}

@php
    $modalId       = $modalId       ?? 'importModal';
    $importRoute   = $importRoute   ?? '#';
    $templateRoute = $templateRoute ?? '#';
    $title         = $title         ?? 'Import Data Excel';
    $columns       = $columns       ?? [];
@endphp

{{-- ── TRIGGER BUTTON (rendered inline, caller embeds this) ── --}}
{{-- CALLER USAGE: @include('components.import-modal', [...]) --}}

{{-- ── MODAL OVERLAY ──────────────────────────────────────── --}}
<div id="{{ $modalId }}"
     class="fixed inset-0 z-[9998] hidden items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="{{ $modalId }}-title">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
         onclick="closeImportModal('{{ $modalId }}')"></div>

    {{-- Dialog --}}
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-200 scale-95 opacity-0"
         id="{{ $modalId }}-dialog">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                </div>
                <h2 id="{{ $modalId }}-title" class="text-base font-bold text-slate-800">{{ $title }}</h2>
            </div>
            <button onclick="closeImportModal('{{ $modalId }}')"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 space-y-4">

            {{-- Step 1: Download template --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-blue-700">1</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1">Unduh Template Excel</p>
                        <p class="text-xs text-slate-500 mb-3">
                            Gunakan template berikut untuk memastikan format kolom sudah benar.
                            Baris kedua adalah <strong>contoh data</strong> yang bisa dihapus.
                        </p>
                        <a href="{{ route($templateRoute) }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Unduh Template (.xlsx)
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom yang tersedia --}}
            @if(!empty($columns))
            <div class="mb-2">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Kolom yang tersedia</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($columns as $col)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs rounded-lg font-mono">
                        {{ $col }}
                        @if(str_ends_with($col, '*'))
                            <span class="text-red-500 font-sans font-bold ml-0.5">*wajib</span>
                        @endif
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Warning Alert --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex gap-3">
                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <p class="text-sm font-bold text-amber-800">Verifikasi File Template</p>
                    <p class="text-xs text-amber-700 mt-0.5">Pastikan Anda menggunakan template khusus halaman ini dan kolom sudah sesuai sebelum memproses import. Salah file dapat menyebabkan data rusak/error.</p>
                </div>
            </div>

            {{-- Step 2: Upload --}}
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-xs font-bold text-emerald-700">2</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-700">Unggah File Excel</p>
                </div>

                <form id="{{ $modalId }}-form"
                      action="{{ route($importRoute) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    {{-- Dropzone --}}
                    <label for="{{ $modalId }}-file"
                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-emerald-400 hover:bg-emerald-50 transition-all duration-200 group"
                           id="{{ $modalId }}-dropzone">
                        <svg class="w-8 h-8 text-slate-300 group-hover:text-emerald-400 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-slate-500 group-hover:text-emerald-600" id="{{ $modalId }}-label">
                            <span class="font-semibold">Klik untuk pilih file</span> atau seret ke sini
                        </p>
                        <p class="text-xs text-slate-400 mt-1">.xlsx, .xls, .csv — Maks. 5 MB</p>
                        <input type="file" id="{{ $modalId }}-file" name="file_excel"
                               accept=".xlsx,.xls,.csv" class="hidden"
                               onchange="handleImportFileChange('{{ $modalId }}', this)">
                    </label>

                    {{-- Validation error for file --}}
                    @error('file_excel')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
            <button onclick="closeImportModal('{{ $modalId }}')"
                    class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                Batal
            </button>
            <button onclick="submitImportForm('{{ $modalId }}')"
                    id="{{ $modalId }}-submit-btn"
                    disabled
                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                </svg>
                <span id="{{ $modalId }}-submit-label">Proses Import</span>
            </button>
        </div>
    </div>
</div>

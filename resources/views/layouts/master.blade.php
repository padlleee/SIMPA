<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic Page Title --}}
    <title>@yield('title', 'SIMPA') – Panti Asuhan Amaliya</title>

    {{-- Favicon / Icon Tab Website --}}
    <link rel="icon" href="{{ asset('images/logo-panti-single.png') }}" type="image/png">

    {{-- SEO Meta --}}
    <meta name="description" content="@yield('meta-description', 'Sistem Informasi Manajemen Panti Asuhan Amaliya – transparansi donasi dan pengelolaan panti.')">

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Chart.js CDN (for dashboard charts) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    {{-- External Custom Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/simpa-style.css') }}">

    {{-- Per-page Styles (pushed by child views) --}}
    @stack('styles')
</head>
<body class="@yield('body-class', 'bg-slate-50 text-slate-800')">

    {{-- Main body slot – overridden by layouts (app.blade.php) or standalone pages (landing) --}}
    @yield('body')

    {{-- Global Scripts --}}
    @stack('scripts')

    {{-- ================================================================
         GLOBAL: Override pesan validasi HTML5 bawaan browser ke Bahasa Indonesia
         Mencakup: valueMissing, typeMismatch, tooShort, tooLong,
                   rangeUnderflow, rangeOverflow, patternMismatch, stepMismatch
         ================================================================ --}}
    <script>
    (function () {
        // Pemetaan tipe input ke pesan "harap isi" yang lebih kontekstual
        const fieldLabels = {
            email    : 'Alamat email',
            password : 'Password',
            number   : 'Angka',
            tel      : 'Nomor telepon',
            url      : 'Alamat URL',
            date     : 'Tanggal',
            file     : 'Berkas',
        };

        function getLabel(input) {
            // Coba ambil label dari elemen <label> terkait
            if (input.id) {
                const lbl = document.querySelector('label[for="' + input.id + '"]');
                if (lbl) return lbl.textContent.trim().replace(/:$/, '');
            }
            // Fallback ke placeholder atau name
            return input.placeholder || fieldLabels[input.type] || 'Kolom ini';
        }

        function setMessages(input) {
            const v     = input.validity;
            const label = getLabel(input);

            if (v.valueMissing) {
                input.setCustomValidity(label + ' wajib diisi.');
            } else if (v.typeMismatch) {
                if (input.type === 'email') {
                    input.setCustomValidity('Format email tidak valid. Contoh: nama@domain.com');
                } else if (input.type === 'url') {
                    input.setCustomValidity('Format URL tidak valid. Contoh: https://contoh.com');
                } else {
                    input.setCustomValidity('Format ' + label.toLowerCase() + ' tidak valid.');
                }
            } else if (v.tooShort) {
                input.setCustomValidity(
                    label + ' harus minimal ' + input.minLength + ' karakter. ' +
                    'Saat ini ' + input.value.length + ' karakter.'
                );
            } else if (v.tooLong) {
                input.setCustomValidity(
                    label + ' tidak boleh lebih dari ' + input.maxLength + ' karakter.'
                );
            } else if (v.rangeUnderflow) {
                input.setCustomValidity(
                    label + ' tidak boleh kurang dari ' + input.min + '.'
                );
            } else if (v.rangeOverflow) {
                input.setCustomValidity(
                    label + ' tidak boleh lebih dari ' + input.max + '.'
                );
            } else if (v.patternMismatch) {
                input.setCustomValidity(
                    'Format ' + label.toLowerCase() + ' tidak sesuai. ' +
                    (input.title ? input.title : 'Harap periksa kembali.')
                );
            } else if (v.stepMismatch) {
                input.setCustomValidity(
                    label + ' harus berupa kelipatan ' + input.step + '.'
                );
            } else {
                // Valid — hapus pesan kustom agar tidak memblokir submit
                input.setCustomValidity('');
            }
        }

        // Pasang event listener ke seluruh form element sekarang dan di masa mendatang
        function attachValidation(root) {
            root.querySelectorAll('input, select, textarea').forEach(function (input) {
                // Saat nilai berubah, reset pesan kustom agar validasi bisa berjalan ulang
                input.addEventListener('input', function () {
                    input.setCustomValidity('');
                });
                // Saat browser hendak menampilkan tooltip invalid, set pesan Indonesia
                input.addEventListener('invalid', function () {
                    setMessages(input);
                });
            });
        }

        // Jalankan setelah DOM siap
        document.addEventListener('DOMContentLoaded', function () {
            attachValidation(document);

            // Amati perubahan DOM (untuk modal atau konten yang dimuat secara dinamis)
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (m) {
                    m.addedNodes.forEach(function (node) {
                        if (node.nodeType === 1) {
                            attachValidation(node);
                        }
                    });
                });
            });
            observer.observe(document.body, { childList: true, subtree: true });
        });
    })();
    </script>
    {{-- ================================================================
         GLOBAL: Custom Confirm Modal (menggantikan browser confirm())
         Penggunaan: simpaConfirm({ title, message, confirmText, type, onConfirm })
         type: 'danger' | 'warning' | 'default'
         ================================================================ --}}
    <div id="simpaConfirmModal"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4 hidden"
         aria-modal="true" role="dialog">
        {{-- Backdrop --}}
        <div id="simpaConfirmBackdrop"
             class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             onclick="simpaConfirmCancel()"></div>

        {{-- Dialog --}}
        <div id="simpaConfirmDialog"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform transition-all duration-200 scale-95 opacity-0">

            {{-- Icon --}}
            <div id="simpaConfirmIcon" class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-4"></div>

            {{-- Title --}}
            <h3 id="simpaConfirmTitle" class="text-base font-bold text-slate-800 text-center mb-2"></h3>

            {{-- Message --}}
            <p id="simpaConfirmMessage" class="text-sm text-slate-500 text-center leading-relaxed mb-6"></p>

            {{-- Buttons --}}
            <div class="flex gap-3">
                <button id="simpaConfirmCancelBtn"
                        onclick="simpaConfirmCancel()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button id="simpaConfirmOkBtn"
                        onclick="simpaConfirmOk()"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition-colors">
                </button>
            </div>
        </div>
    </div>

    <script>
    // ── Global Confirm Modal ───────────────────────────────────────────
    let _simpaConfirmCallback = null;

    const _simpaVariants = {
        danger: {
            iconBg  : 'bg-red-100',
            iconSvg : `<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`,
            btnClass: 'bg-red-600 hover:bg-red-700',
        },
        warning: {
            iconBg  : 'bg-amber-100',
            iconSvg : `<svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>`,
            btnClass: 'bg-amber-500 hover:bg-amber-600',
        },
        default: {
            iconBg  : 'bg-slate-100',
            iconSvg : `<svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            btnClass: 'bg-slate-800 hover:bg-slate-700',
        },
    };

    function simpaConfirm({ title, message, confirmText = 'Ya, Lanjutkan', type = 'default', onConfirm }) {
        _simpaConfirmCallback = onConfirm;
        const v = _simpaVariants[type] || _simpaVariants.default;

        document.getElementById('simpaConfirmIcon').className   = 'w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-4 ' + v.iconBg;
        document.getElementById('simpaConfirmIcon').innerHTML   = v.iconSvg;
        document.getElementById('simpaConfirmTitle').textContent   = title;
        document.getElementById('simpaConfirmMessage').textContent = message;
        document.getElementById('simpaConfirmOkBtn').textContent   = confirmText;
        document.getElementById('simpaConfirmOkBtn').className      =
            'flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition-colors ' + v.btnClass;

        const modal  = document.getElementById('simpaConfirmModal');
        const dialog = document.getElementById('simpaConfirmDialog');
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            dialog.classList.remove('scale-95', 'opacity-0');
            dialog.classList.add('scale-100', 'opacity-100');
        });
    }

    function _simpaConfirmClose() {
        const modal  = document.getElementById('simpaConfirmModal');
        const dialog = document.getElementById('simpaConfirmDialog');
        dialog.classList.remove('scale-100', 'opacity-100');
        dialog.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 180);
    }

    function simpaConfirmOk() {
        _simpaConfirmClose();
        if (typeof _simpaConfirmCallback === 'function') _simpaConfirmCallback();
    }

    function simpaConfirmCancel() {
        _simpaConfirmClose();
    }

    // Tutup dengan Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') simpaConfirmCancel();
    });
    </script>

</body>
</html>

<!-- Register Modal Component -->
<div id="registerModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] flex flex-col md:flex-row overflow-hidden relative">
        
        <!-- Close Button (Absolute Top Right) -->
        <button onclick="closeRegisterModal()" class="absolute top-4 right-4 z-20 bg-white/50 hover:bg-white text-slate-500 hover:text-slate-800 p-2 rounded-full transition-all backdrop-blur-md shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Left Side: Benefits & FAQ (Scrollable on mobile) -->
        <div class="w-full md:w-5/12 bg-gradient-to-br from-slate-50 to-blue-50 border-r border-slate-200 p-8 md:p-10 overflow-y-auto max-h-[40vh] md:max-h-[90vh]">
            <div class="flex items-center gap-3 mb-8">
                <img src="/storage/img/logo-panti-single.png" alt="Logo" class="w-10 h-10 rounded-lg object-cover shadow-sm">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 leading-tight">Yayasan Amaliya</h2>
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Portal Donatur</p>
                </div>
            </div>

            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                Keunggulan Donatur Tetap
            </h3>
            
            <ul class="space-y-4 mb-10">
                <li class="flex items-start gap-3">
                    <div class="bg-blue-100 text-blue-600 p-1.5 rounded-lg shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-800">Transparansi Penyaluran</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Akses laporan bulanan dan pantau langsung bagaimana dana Anda digunakan untuk kesejahteraan anak asuh.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="bg-emerald-100 text-emerald-600 p-1.5 rounded-lg shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-800">Histori Donasi Terpusat</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Seluruh riwayat donasi Anda tersimpan rapi. Unduh kwitansi digital kapan saja Anda butuhkan.</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="bg-purple-100 text-purple-600 p-1.5 rounded-lg shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-800">Kemudahan Berdonasi</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Proses verifikasi yang lebih cepat dan tidak perlu mengisi data diri berulang kali pada donasi berikutnya.</p>
                    </div>
                </li>
            </ul>

            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                FAQ Sistem
            </h3>
            <div class="space-y-3">
                <details class="group bg-white p-3 rounded-lg border border-slate-200 shadow-sm cursor-pointer [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex justify-between items-center text-sm font-semibold text-slate-700">
                        Apakah data saya aman?
                        <span class="transition group-open:rotate-180">
                            <svg fill="none" height="20" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="20"><path d="M6 9l6 6 6-6"></path></svg>
                        </span>
                    </summary>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">Sangat aman. Sistem SIMPA menggunakan enkripsi modern. Data Anda hanya digunakan untuk keperluan pelaporan donasi dan tidak akan dibagikan ke pihak ketiga.</p>
                </details>
                <details class="group bg-white p-3 rounded-lg border border-slate-200 shadow-sm cursor-pointer [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex justify-between items-center text-sm font-semibold text-slate-700">
                        Kapan akun saya aktif?
                        <span class="transition group-open:rotate-180">
                            <svg fill="none" height="20" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="20"><path d="M6 9l6 6 6-6"></path></svg>
                        </span>
                    </summary>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">Proses persetujuan biasanya memakan waktu maksimal 1x24 jam. Kredensial login akan otomatis dikirimkan ke email yang Anda daftarkan.</p>
                </details>
                <details class="group bg-white p-3 rounded-lg border border-slate-200 shadow-sm cursor-pointer [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex justify-between items-center text-sm font-semibold text-slate-700">
                        Apakah ada nominal minimum?
                        <span class="transition group-open:rotate-180">
                            <svg fill="none" height="20" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="20"><path d="M6 9l6 6 6-6"></path></svg>
                        </span>
                    </summary>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">Tidak ada batas minimum atau kewajiban rutin. Menjadi donatur tetap berarti Anda mendukung transparansi dan tercatat sebagai keluarga Panti Amaliya.</p>
                </details>
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="w-full md:w-7/12 p-8 md:p-12 overflow-y-auto max-h-[90vh] bg-white">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Formulir Pendaftaran</h2>
            <p class="text-slate-500 text-sm mb-8">Isi formulir di bawah ini untuk mengajukan akun Donatur Tetap.</p>

            <form id="modalRegisterForm" action="{{ route('account-request.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               placeholder="Contoh: Budi Santoso"
                               class="pl-11 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600 transition bg-slate-50 focus:bg-white @error('nama_lengkap') border-red-400 @enderror">
                    </div>
                    @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="anda@email.com"
                                   class="pl-11 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600 transition bg-slate-50 focus:bg-white @error('email') border-red-400 @enderror">
                        </div>
                        @if($errors->has('email') && (old('nama_lengkap') !== null || $errors->has('nama_lengkap')))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP / WA <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                   maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   placeholder="0812xxxxxxxx"
                                   class="pl-11 w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600 transition bg-slate-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <!-- Pesan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pesan / Motivasi Bergabung <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea name="pesan" rows="3" maxlength="500"
                              placeholder="Ceritakan motivasi singkat Anda bergabung dengan kami..."
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-600 transition bg-slate-50 focus:bg-white resize-none">{{ old('pesan') }}</textarea>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4 flex gap-3 mt-2">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-blue-800 text-xs leading-relaxed">Setelah disetujui oleh admin, akun Donatur Anda akan diaktifkan dan password sementara akan dikirimkan ke email Anda.</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-slate-800 text-white py-4 rounded-xl font-bold tracking-wide hover:bg-slate-700 transition-colors mt-6 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group">
                    Kirim Permintaan Bergabung
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-slate-500 text-sm">
                    Sudah punya akun? 
                    <button type="button" onclick="closeRegisterModal(); openLoginModal();" class="text-blue-600 font-semibold hover:text-blue-700 hover:underline">Masuk di sini</button>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function openRegisterModal() {
        document.getElementById('registerModal').classList.remove('hidden');
        setTimeout(() => {
            document.querySelector('#modalRegisterForm input[name="nama_lengkap"]').focus();
        }, 100);
    }

    function closeRegisterModal() {
        document.getElementById('registerModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('registerModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRegisterModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRegisterModal();
        }
    });

    // Open modal if requested via URL param (from success page CTA)
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('register') === 'true') {
            // Remove the query param so it doesn't reopen on refresh
            window.history.replaceState({}, document.title, window.location.pathname);
            openRegisterModal();
        }
    });

    // Open modal if requested via session
    @if(session('showRegisterModal'))
        openRegisterModal();
    @endif

    // Open modal if there are validation errors specific to the register form
    @php
        $isRegisterError = $errors->has('nama_lengkap') || old('nama_lengkap') !== null;
    @endphp
    @if($isRegisterError && $errors->any())
        openRegisterModal();
    @endif
</script>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password – SIMPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Ubah Password</h1>
            <p class="text-slate-500 text-sm mt-2">Keamanan akun Anda dimulai dari sini</p>
        </div>

        <!-- Alert -->
        @if(session('info'))
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl p-4 text-sm flex gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('info') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm flex gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-6">
            <p class="text-slate-600 text-sm mb-6">Password Anda harus memenuhi kriteria berikut:</p>

            <ul class="space-y-2 mb-8 text-sm">
                <li class="flex gap-3 text-slate-600">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Minimal 8 karakter
                </li>
                <li class="flex gap-3 text-slate-600">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mengandung huruf besar (A-Z)
                </li>
                <li class="flex gap-3 text-slate-600">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mengandung huruf kecil (a-z)
                </li>
                <li class="flex gap-3 text-slate-600">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mengandung angka (0-9)
                </li>
            </ul>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('current_password') border-red-400 @enderror"
                           placeholder="Masukkan password saat ini">
                    @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                    <input type="password" name="password" required
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('password') border-red-400 @enderror"
                           placeholder="Masukkan password baru" id="password">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('password_confirmation') border-red-400 @enderror"
                           placeholder="Konfirmasi password baru">
                    @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                    Ubah Password
                </button>
            </form>
        </div>

        <p class="text-center text-slate-400 text-xs">
            Perubahan password akan diterapkan secara otomatis setelah Anda mengirimkan form ini.
        </p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – SIMPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">SIMPA</h1>
            <p class="text-slate-500 text-sm mt-1">Panti Asuhan Amaliya</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <h2 class="text-xl font-semibold text-slate-800 mb-6">Masuk ke Sistem</h2>

            @if($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            @if(session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition @error('username') border-red-400 @enderror"
                           placeholder="Masukkan username">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition"
                           placeholder="••••••••">
                </div>
                <button type="submit" class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-semibold hover:bg-slate-700 transition-colors">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-slate-400 text-sm mt-6">
            <a href="{{ route('landing') }}" class="hover:text-slate-700 transition-colors">← Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>

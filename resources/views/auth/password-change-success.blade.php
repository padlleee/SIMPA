<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Berhasil Diubah – SIMPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-down { animation: slideDown 0.5s ease-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-green-200 p-8 text-center animate-slide-down">
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-slate-800 mb-2">Berhasil!</h1>
            <p class="text-slate-600 text-lg mb-2">Password Anda telah berhasil diubah.</p>
            <p class="text-slate-500 text-sm mb-8">Anda sekarang dapat melanjutkan ke dashboard sistem dengan akun yang lebih aman.</p>

            <!-- User Info -->
            <div class="bg-slate-50 rounded-xl p-4 mb-8 border border-slate-200">
                <p class="text-slate-600 text-sm">Terdaftar sebagai:</p>
                <p class="text-lg font-bold text-slate-800">{{ Auth::user()->username }}</p>
                <p class="text-sm text-slate-600 mt-1">
                    <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full font-medium text-xs">
                        {{ Auth::user()->role }}
                    </span>
                </p>
            </div>

            <!-- Info Message -->
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-3 text-sm mb-6 flex gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- CTA Button -->
            <a href="{{ route('dashboard') }}" class="inline-block w-full bg-blue-600 text-white py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors mb-4">
                Lanjut ke Dashboard →
            </a>

            <!-- Secondary Link -->
            <a href="{{ route('logout') }}" class="inline-block text-slate-600 hover:text-slate-800 font-medium text-sm transition-colors"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                atau Keluar dari Sistem
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center text-slate-500 text-xs">
            <p>Terakhir login: <span class="font-medium">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d M Y H:i') : '-' }}</span></p>
        </div>
    </div>
</body>
</html>

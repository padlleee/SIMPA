<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic Page Title --}}
    <title>@yield('title', 'SIMPA') – Panti Asuhan Amaliya</title>

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

</body>
</html>

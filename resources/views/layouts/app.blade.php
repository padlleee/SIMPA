{{-- ============================================================
     Middle-tier Layout: layouts/app.blade.php
     Used by ALL admin/staff/donatur dashboard pages.
     Strategy: This file extends master.blade.php so that all
     30+ child pages using @extends('layouts.app') continue to
     work without ANY modification.
     ============================================================ --}}
@extends('layouts.master')

@section('body')

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR (extracted partial) --}}
    @include('layouts.partials.sidebar')

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-1 ml-64 flex flex-col overflow-hidden">

        {{-- TOP BAR (extracted partial – includes notification logic) --}}
        @include('layouts.partials.topbar')

        {{-- PAGE CONTENT --}}
        <main class="flex-1 overflow-y-auto p-8">

            {{-- Flash Messages (extracted partial) --}}
            @include('layouts.partials.flash')

            {{-- Child page content injected here --}}
            @yield('content')

        </main>
    </div>

</div>

@endsection

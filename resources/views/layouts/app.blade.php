<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AI-Powered Warehouse Delivery Alerts') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen text-white bg-primary-900 relative">
    {{-- Optional particle canvas --}}
    <canvas id="particles"></canvas>

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-30 bg-black/30 backdrop-blur border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                {{-- Minimal logo (warehouse + radar) --}}
                <svg width="28" height="28" viewBox="0 0 24 24" class="text-accent">
                  <path fill="currentColor" d="M12 2L3 6v12h18V6L12 2zM6 9h12v7H6V9z"/>
                  <circle cx="12" cy="13" r="1.5" fill="currentColor"/>
                  <path fill="currentColor" d="M12 13a4 4 0 0 1 4 4h-1.5a2.5 2.5 0 0 0-2.5-2.5V13z"/>
                </svg>
                <span class="font-semibold tracking-tight">
                  AI-Powered <span class="text-accent">Warehouse Delivery Alerts</span>
                </span>
            </a>
            <ul class="flex items-center gap-6 text-sm">
                <li><a href="/" class="hover:text-accent">Home</a></li>
                <li><a href="/proximity-form" class="hover:text-accent">Check Proximity</a></li>
                <li><a href="/proximity-history" class="hover:text-accent">History</a></li>
            </ul>
        </div>
    </nav>

    {{-- PAGE WRAPPER (full-bleed override-able) --}}
    <main class="@yield('main-class','max-w-7xl mx-auto px-4 py-10') relative z-10">
        @yield('content')
    </main>

    <footer class="mt-16 border-t border-white/10 bg-black/30 backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 py-6 text-sm text-white/70">
            © {{ date('Y') }} AI-Powered Warehouse Delivery Alerts. All rights reserved.
        </div>
    </footer>
</body>
</html>

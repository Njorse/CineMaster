<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CineMaster 🎬') }}</title>
    <link rel="icon" href="{{ asset('img/logocine.png') }}" type="image/png">

    <!-- Tipografía Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-[#0f0f0f] text-white font-[Montserrat] min-h-screen flex flex-col relative overflow-x-hidden selection:bg-orange-500 selection:text-white">

    {{-- Background Effects --}}
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-orange-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-600/5 rounded-full blur-[120px]"></div>
    </div>

    {{-- Header --}}
    <header class="relative z-10 w-full border-b border-white/5 bg-[#0f0f0f]/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-center sm:justify-between items-center">
            <a href="/" class="text-3xl font-extrabold tracking-tight flex items-center gap-2 group">
                <span
                    class="bg-gradient-to-r from-orange-500 to-amber-500 bg-clip-text text-transparent group-hover:scale-105 transition-transform duration-300">🎬
                    CineMaster</span>
            </a>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="relative z-10 flex-1 flex flex-col justify-center items-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full sm:max-w-md">
            {{-- Card: Solid Dark with subtle border --}}
            <div
                class="bg-[#1a1a1a] border border-slate-800 rounded-3xl shadow-2xl shadow-black/50 p-8 sm:p-10 relative overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <x-footer />

</body>

</html>
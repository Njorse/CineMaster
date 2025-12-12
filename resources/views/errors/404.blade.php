@extends('layouts.app')

@section('content')
    <div class="bg-[#0f0f0f] min-h-[80vh] flex items-center justify-center px-4 font-[Montserrat]">
        <div class="text-center max-w-lg mx-auto">

            {{-- Big 404 with Gradient --}}
            <h1
                class="text-6xl md:text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-yellow-500 mb-4 animate-pulse">
                404
            </h1>

            {{-- Message --}}
            <h2 class="text-3xl font-bold text-white mb-6">¡Corte! Escena no encontrada</h2>

            <p class="text-slate-400 text-lg mb-8 leading-relaxed">
                Parece que esta película no está en nuestro catálogo o el rollo se perdió en la sala de edición.
            </p>

            {{-- Illustration / Icon --}}
            <div class="flex justify-center mb-10">
                <div
                    class="w-32 h-32 bg-slate-800/50 rounded-full flex items-center justify-center relative overflow-hidden group">
                    <svg class="w-16 h-16 text-slate-600 group-hover:text-orange-500 transition-colors duration-500"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    {{-- Animated grain effect --}}
                    <div class="absolute inset-0 bg-transparent opacity-20 pointer-events-none mix-blend-overlay"
                        style="background-image: url('data:image/svg+xml,...');"></div>
                </div>
            </div>

            {{-- Action Button --}}
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-400 text-white font-bold rounded-full shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Volver al Cine
            </a>

        </div>
    </div>
@endsection
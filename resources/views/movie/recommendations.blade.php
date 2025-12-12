@extends('layouts.app')

@section('content')

    <div class="bg-[#0f0f0f] text-white font-[Montserrat] min-h-screen pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="mb-24 border-b border-slate-800 pb-8">
                <h1 class="text-3xl md:text-3xl font-extrabold tracking-tight text-white mb-4">
                    Películas <span
                        class="bg-gradient-to-r from-orange-500 to-yellow-500 bg-clip-text text-transparent">Recomendadas</span>
                </h1>
                <p class="text-slate-400 text-sm font-light max-w-2xl">
                    {{ $mensaje }}
                    @if(isset($ultimaInteraccion) && $ultimaInteraccion->pelicula)
                        <a href="{{ route('movie.show', $ultimaInteraccion->pelicula->tmdb_id) }}"
                            class="text-orange-400 hover:text-orange-300 ml-1 inline-flex items-center gap-1 transition-colors group">
                            <span class="underline decoration-orange-500/30 group-hover:decoration-orange-500">
                                {{ $ultimaInteraccion->pelicula->titulo }}
                            </span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>{{ $mensajeSufijo }}
                    @endif
                </p>
            </div>

            @if(count($recomendaciones) > 0)
                {{-- GRID LAYOUT --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">

                    @foreach($recomendaciones as $movie)
                        <div
                            class="group relative bg-[#1a1a1a] rounded-xl overflow-hidden shadow-lg hover:shadow-orange-500/10 transition-all duration-300 hover:-translate-y-1">

                            {{-- POSTER --}}
                            <div class="aspect-[2/3] relative overflow-hidden bg-slate-900">
                                <a href="{{ route('movie.show', $movie['id']) }}" class="block w-full h-full">
                                    @if(isset($movie['poster_path']) && $movie['poster_path'])
                                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                            alt="{{ $movie['title'] }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-600">
                                            <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="text-xs font-medium">Sin Imagen</span>
                                        </div>
                                    @endif

                                    {{-- OVERLAY (Desktop) --}}
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="bg-orange-500 text-black text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                {{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                                            </span>
                                            <span class="flex items-center gap-1 text-yellow-400 text-xs font-bold">
                                                ★ {{ number_format($movie['vote_average'], 1) }}
                                            </span>
                                        </div>
                                        <span
                                            class="text-white text-xs font-bold uppercase tracking-wider border border-white/30 px-3 py-2 rounded-lg text-center hover:bg-white hover:text-black transition-colors">
                                            Ver Detalles
                                        </span>
                                    </div>
                                </a>
                            </div>

                            {{-- INFO (Mobile/Always visible) --}}
                            <div class="p-3">
                                <a href="{{ route('movie.show', $movie['id']) }}">
                                    <h3 class="font-bold text-sm text-slate-200 line-clamp-1 group-hover:text-orange-500 transition-colors"
                                        title="{{ $movie['title'] }}">
                                        {{ $movie['title'] }}
                                    </h3>
                                </a>
                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-200 mb-2">Sin recomendaciones por ahora</h2>
                    <p class="text-slate-400 max-w-md mx-auto mb-8">
                        Interactúa con más películas (califica o agrega a favoritos) para que podamos aprender tus gustos y
                        sugerirte lo mejor.
                    </p>
                    <a href="{{ route('home') }}"
                        class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-full transition-all shadow-lg shadow-orange-500/20">
                        Explorar Catálogo
                    </a>
                </div>
            @endif

        </div>
    </div>

@endsection
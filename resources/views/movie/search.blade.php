@extends('layouts.app')

@section('content')
<div class="pt-8 md:pt-12 min-h-[80vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- TÍTULO --}}
        <div class="mb-8 md:mb-12 border-b border-orange-600/30 pb-4">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                Resultados para: <span class="text-orange-500">"{{ $query }}"</span>
            </h1>
        </div>

        @if(count($movies) > 0)
            {{-- GRID DE PELÍCULAS --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                @foreach($movies as $movie)
                    <div class="group relative bg-[#1a1a1a] rounded-xl overflow-hidden shadow-lg hover:shadow-orange-500/20 transition-all duration-300 transform hover:-translate-y-1 border border-white/5 hover:border-orange-500/30">
                        <a href="{{ route('movie.show', $movie['id']) }}" class="block h-full flex flex-col">
                            {{-- IMAGEN --}}
                            <div class="relative aspect-[2/3] overflow-hidden bg-gray-900">
                                @if(isset($movie['poster_path']) && $movie['poster_path'])
                                    <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                         alt="{{ $movie['title'] }}"
                                         class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-800 text-gray-500 p-4 text-center">
                                        <span class="text-xs">Sin Imagen</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-4">
                                    <span class="text-orange-400 font-bold text-xs md:text-sm uppercase tracking-wide">Ver detalles</span>
                                </div>
                            </div>
                            {{-- INFO --}}
                            <div class="p-3 md:p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-white font-bold text-sm md:text-base leading-tight line-clamp-2 mb-1" title="{{ $movie['title'] }}">
                                        {{ $movie['title'] }}
                                    </h3>
                                </div>
                                <div class="flex justify-between items-end mt-2 pt-2 border-t border-white/5">
                                    <span class="text-gray-500 text-xs font-medium">
                                        {{ isset($movie['release_date']) ? \Carbon\Carbon::parse($movie['release_date'])->format('Y') : 'N/A' }}
                                    </span>
                                    <div class="flex items-center gap-1 text-yellow-500 text-xs font-bold bg-yellow-500/10 px-1.5 py-0.5 rounded">
                                        <span>★</span> {{ isset($movie['vote_average']) ? round($movie['vote_average'], 1) : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            {{-- ESTADO VACÍO --}}
            <div class="text-center py-16 md:py-24 px-4">
                <div class="inline-block p-4 rounded-full bg-gray-800/50 mb-4">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-300 mb-2">No encontramos nada</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Intenta con otro título o revisa la ortografía.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 hover:bg-orange-500 text-white font-bold rounded-full transition shadow-lg shadow-orange-900/20">
                    Volver al Inicio
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

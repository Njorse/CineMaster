@extends('layouts.app')

@section('content')

    <div class="bg-[#0f0f0f] text-white font-[Montserrat] min-h-screen pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-24 gap-4">
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight flex items-center gap-2">
                    <span class="bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent">Mis
                        Favoritos</span>
                    <span class="text-2xl">❤️</span>
                </h1>
                <div class="text-slate-400 text-sm font-medium">
                    {{ $favoritos->count() }} {{ Str::plural('película', $favoritos->count()) }}
                    guardada{{ $favoritos->count() !== 1 ? 's' : '' }}
                </div>
            </div>

            @if($favoritos->isEmpty())
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 bg-slate-800/50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-200 mb-2">Tu lista está vacía</h2>
                    <p class="text-slate-400 max-w-md mx-auto mb-8">
                        Parece que aún no has guardado ninguna película. Explora nuestro catálogo y guarda las que más te
                        gusten.
                    </p>
                    <a href="{{ route('home') }}"
                        class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-full transition-all shadow-lg shadow-orange-500/20">
                        Explorar Películas
                    </a>
                </div>

            @else
                {{-- GRID LAYOUT --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                    @foreach($favoritos as $favorito)
                        <div
                            class="group relative bg-[#1a1a1a] rounded-xl overflow-hidden shadow-lg hover:shadow-orange-500/10 transition-all duration-300 hover:-translate-y-1">

                            {{-- POSTER --}}
                            <div class="aspect-[2/3] relative overflow-hidden">
                                <a href="{{ route('movie.show', $favorito->pelicula->tmdb_id) }}" class="block w-full h-full">
                                    <img src="https://image.tmdb.org/t/p/w500{{ $favorito->pelicula->poster_path }}"
                                        alt="{{ $favorito->pelicula->titulo }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                                    {{-- OVERLAY (Desktop) --}}
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                        <p class="text-xs text-orange-400 font-bold mb-1">
                                            Agregada el {{ $favorito->created_at->format('d/m/Y') }}
                                        </p>
                                        <form action="{{ route('favoritos.toggle') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tmdb_id" value="{{ $favorito->pelicula->tmdb_id }}">
                                            <button type="submit"
                                                class="w-full py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </a>
                            </div>

                            {{-- INFO (Mobile/Always visible) --}}
                            <div class="p-3">
                                <a href="{{ route('movie.show', $favorito->pelicula->tmdb_id) }}">
                                    <h3
                                        class="font-bold text-sm text-slate-200 line-clamp-1 group-hover:text-orange-500 transition-colors">
                                        {{ $favorito->pelicula->titulo }}
                                    </h3>
                                </a>

                                {{-- Mobile Remove Button (Visible only on touch/small screens if needed, or rely on card tap) --}}
                                {{-- For better UX on mobile, we can keep the remove button visible or rely on the overlay if it
                                works on tap.
                                Let's add a small remove icon for mobile that is always visible --}}
                                <div class="mt-2 flex justify-between items-center lg:hidden">
                                    <span class="text-[10px] text-slate-500">{{ $favorito->created_at->format('d M') }}</span>
                                    <form action="{{ route('favoritos.toggle') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tmdb_id" value="{{ $favorito->pelicula->tmdb_id }}">
                                        <button type="submit" class="text-red-500 p-1 hover:bg-red-500/10 rounded">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
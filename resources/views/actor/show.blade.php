@extends('layouts.app')

@section('content')
    <div class="bg-[#1f1f1f] min-h-screen text-white font-sans pb-12">

        {{-- CONTENT CONTAINER --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 md:pt-16">

            <div class="flex flex-col md:flex-row gap-8 lg:gap-12">

                {{-- LEFT COLUMN: PROFILE IMAGE & PERSONAL INFO --}}
                <div class="w-full md:w-1/3 lg:w-1/4 flex-shrink-0">
                    <div class="sticky top-24">
                        <div class="rounded-xl overflow-hidden shadow-2xl mb-6">
                            @if($actor['profile_path'])
                                <img src="https://image.tmdb.org/t/p/w500{{ $actor['profile_path'] }}"
                                    alt="{{ $actor['name'] }}" class="w-full h-auto object-cover">
                            @else
                                <div class="w-full aspect-[2/3] bg-slate-800 flex items-center justify-center text-slate-500">
                                    <svg class="w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-white border-b border-slate-700 pb-2 mb-4">Información
                                Personal</h3>

                            <div>
                                <span class="block text-slate-400 text-sm font-semibold">Conocido por</span>
                                <span class="text-slate-200">{{ $actor['known_for_department'] }}</span>
                            </div>

                            <div>
                                <span class="block text-slate-400 text-sm font-semibold">Fecha de Nacimiento</span>
                                <span
                                    class="text-slate-200">{{ $actor['birthday'] ? date('d/m/Y', strtotime($actor['birthday'])) : 'N/A' }}</span>
                                @if($actor['birthday'])
                                    <span class="text-slate-400 text-sm">({{ \Carbon\Carbon::parse($actor['birthday'])->age }}
                                        años)</span>
                                @endif
                            </div>

                            @if(isset($actor['place_of_birth']))
                                <div>
                                    <span class="block text-slate-400 text-sm font-semibold">Lugar de Nacimiento</span>
                                    <span class="text-slate-200">{{ $actor['place_of_birth'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: BIO & FILMOGRAPHY --}}
                <div class="flex-1">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">{{ $actor['name'] }}</h1>

                    <div class="mb-12">
                        <h3 class="text-xl font-bold text-white mb-4">Biografía</h3>
                        <div class="text-slate-300 leading-relaxed text-lg space-y-4">
                            @if($actor['biography'])
                                <p>{{ $actor['biography'] }}</p>
                            @else
                                <p class="italic text-slate-500">No hay biografía disponible.</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-white mb-6">Películas Conocidas</h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($movies as $movie)
                                <a href="{{ route('movie.show', $movie['id']) }}" class="group block">
                                    <div class="relative rounded-lg overflow-hidden bg-slate-800 shadow-lg aspect-[2/3] mb-2">
                                        @if($movie['poster_path'])
                                            <img src="https://image.tmdb.org/t/p/w300{{ $movie['poster_path'] }}"
                                                alt="{{ $movie['title'] }}"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-600">
                                                <span class="text-xs">Sin Imagen</span>
                                            </div>
                                        @endif

                                        <div
                                            class="absolute top-2 right-2 bg-black/60 backdrop-blur-sm px-2 py-1 rounded text-xs font-bold text-orange-400">
                                            ★ {{ number_format($movie['vote_average'], 1) }}
                                        </div>
                                    </div>
                                    <h4
                                        class="text-slate-200 font-semibold text-sm line-clamp-1 group-hover:text-orange-400 transition-colors">
                                        {{ $movie['title'] }}
                                    </h4>
                                </a>
                            @endforeach
                        </div>

                        @if(count($movies) == 0)
                            <p class="text-slate-500">No se encontraron películas para este actor.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
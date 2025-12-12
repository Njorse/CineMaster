@extends('layouts.app')

@section('content')
    <div class="bg-[#1f1f1f] min-h-screen text-white font-sans pb-12">

        {{-- HEADER SECTION --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-6">
            {{-- Top Navigation --}}
            <div class="flex justify-between items-center mb-6 text-sm text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-orange-500 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al inicio
                </a>

            </div>

            {{-- Title & Basic Info --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-4xl md:text-5xl font-normal text-white mb-2">
                        {{ $movie['title'] }}
                    </h1>
                    <div class="flex items-center gap-4 text-sm text-slate-400">
                        <span>{{ substr($movie['release_date'] ?? '', 0, 4) }}</span>
                        <span class="w-1 h-1 bg-slate-500 rounded-full"></span>
                        <span>{{ isset($movie['runtime']) ? floor($movie['runtime'] / 60) . 'h ' . ($movie['runtime'] % 60) . 'm' : 'N/A' }}</span>
                    </div>
                </div>

                {{-- METRICS BAR --}}
                <div class="flex items-center gap-6 md:gap-12 bg-[#1f1f1f] md:bg-transparent py-4 md:py-0">

                    {{-- 1. TMDB RATING --}}
                    <div class="flex flex-col items-center md:items-start">
                        <span class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1">Calificación
                            TMDB</span>
                        <div class="flex items-center gap-2">
                            <svg class="w-8 h-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.175 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.075 9.384c-.784-.57-.38-1.81.588-1.81h4.15a1 1 0 00.951-.69l1.285-3.957z" />
                            </svg>
                            <div>
                                <div class="flex items-end gap-1">
                                    <span
                                        class="text-xl font-bold text-white">{{ number_format($movie['vote_average'], 1) }}</span>
                                    <span class="text-sm text-slate-400 mb-1">/10</span>
                                </div>
                                <div class="text-xs text-slate-500">{{ number_format($movie['vote_count']) }} votos</div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. USER ACTIVITY (Me gusta + Stars) --}}
                    <div class="flex flex-col items-center md:items-start gap-2">
                        <span class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1">Tu Actividad</span>
                        <div class="flex flex-col gap-2">
                            {{-- Favorite Button --}}
                            @auth
                                <form action="{{ route('favoritos.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                    <input type="hidden" name="titulo" value="{{ $movie['title'] }}">
                                    <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] }}">
                                    <button type="submit"
                                        class="flex items-center gap-2 text-sm font-semibold transition {{ $isFavorite ? 'text-orange-500 hover:text-orange-400' : 'text-slate-300 hover:text-white' }}">
                                        @if($isFavorite)
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span>Te gusta</span>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            <span>Me gusta</span>
                                        @endif
                                    </button>
                                </form>
                            @endauth

                            {{-- Rating Stars --}}
                            @auth
                                <div x-data="{ rating: {{ $userRating ?? 0 }}, hoverRating: 0 }">
                                    <form action="{{ route('calificaciones.store') }}" method="POST" x-ref="ratingForm">
                                        @csrf
                                        <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                        <input type="hidden" name="titulo" value="{{ $movie['title'] }}">
                                        <input type="hidden" name="poster_path" value="{{ $movie['poster_path'] }}">
                                        <input type="hidden" name="rating" :value="rating">
                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center gap-1">
                                                <template x-for="i in 5" :key="i">
                                                    <svg @mouseover="hoverRating = i" @mouseleave="hoverRating = 0"
                                                        @click="rating = i; $nextTick(() => $refs.ratingForm.submit())"
                                                        :class="(i <= (hoverRating || rating)) ? 'text-orange-500' : 'text-slate-600'"
                                                        class="w-6 h-6 cursor-pointer transition-colors" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.175 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.075 9.384c-.784-.57-.38-1.81.588-1.81h4.15a1 1 0 00.951-.69l1.285-3.957z" />
                                                    </svg>
                                                </template>
                                            </div>

                                            {{-- Remove Rating Button --}}
                                            <button type="button" x-show="rating > 0"
                                                @click="rating = 0; $nextTick(() => $refs.ratingForm.submit())"
                                                class="text-slate-500 hover:text-red-500 transition tooltip-trigger"
                                                title="Quitar calificación">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-orange-400 hover:underline">Inicia sesión</a>
                            @endauth
                        </div>
                    </div>

                    {{-- 3. POPULARITY --}}
                    <div class="flex flex-col items-center md:items-start">
                        <span class="text-xs font-bold tracking-widest text-slate-400 uppercase mb-1">Popularidad</span>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full border-2 border-green-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-white">{{ number_format($movie['popularity'], 0) }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- MEDIA HERO SECTION --}}
        <div class="bg-[#1a1a1a] py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-1">

                    {{-- POSTER (Left) --}}
                    <div class="w-full md:w-1/4 lg:w-[280px] flex-shrink-0 relative">
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}"
                            class="w-full h-auto object-cover shadow-lg">

                        {{-- Favorite Button Overlay (Redundant but kept for visual consistency if user wants it on poster
                        too, but user asked for it in header. I will remove it from poster to avoid confusion or keep it?
                        User said "el megusta tambien por q ya esto la logica metelo encima envez de esa estrealla". It
                        implies moving it. I will remove it from poster to be clean.) --}}
                        {{-- Actually, user said "la imagen hazlo pequeña no exagerada". I'll keep the poster clean. --}}
                    </div>

                    {{-- TRAILER / BACKDROP (Right) --}}
                    <div class="flex-1 bg-black relative aspect-video md:aspect-auto md:h-auto">
                        @if(isset($movie['videos']['results']) && count($movie['videos']['results']) > 0)
                            @php
                                $trailer = collect($movie['videos']['results'])->firstWhere('type', 'Trailer') ?? $movie['videos']['results'][0];
                            @endphp
                            <iframe class="w-full h-full absolute inset-0 md:relative md:h-[420px] lg:h-[420px]"
                                src="https://www.youtube.com/embed/{{ $trailer['key'] }}?rel=0&autoplay=0" title="Trailer"
                                frameborder="0" allowfullscreen></iframe>
                        @else
                            <img src="https://image.tmdb.org/t/p/original{{ $movie['backdrop_path'] }}"
                                class="w-full h-full object-cover opacity-80" alt="Backdrop">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-slate-500 text-lg">No hay trailer disponible</span>
                            </div>
                        @endif
                    </div>

                    {{-- MEDIA COUNT (Images/Videos) - Optional Sidebar --}}
                    <div class="hidden lg:flex flex-col gap-1 w-48">
                        <div
                            class="bg-[#2a2a2a] h-1/2 flex flex-col items-center justify-center hover:bg-[#333] transition cursor-pointer group">
                            <svg class="w-8 h-8 text-slate-400 group-hover:text-white mb-2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs font-bold text-slate-300 uppercase">Videos</span>
                            <span class="text-lg font-bold text-white">{{ count($movie['videos']['results'] ?? []) }}</span>
                        </div>
                        <div
                            class="bg-[#2a2a2a] h-1/2 flex flex-col items-center justify-center hover:bg-[#333] transition cursor-pointer group">
                            <svg class="w-8 h-8 text-slate-400 group-hover:text-white mb-2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-bold text-slate-300 uppercase">Fotos</span>
                            <span class="text-lg font-bold text-white">99+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT SECTION --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-12">

                {{-- MAIN INFO --}}
                <div class="flex-1">
                    {{-- GENRES --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($movie['genres'] as $genre)
                            <span
                                class="px-3 py-1 rounded-full border border-slate-600 text-slate-300 text-sm hover:bg-slate-800 transition cursor-default">
                                {{ $genre['name'] }}
                            </span>
                        @endforeach
                    </div>

                    {{-- OVERVIEW --}}
                    <p class="text-lg text-white leading-relaxed mb-8">
                        {{ $movie['overview'] }}
                    </p>

                    <div class="border-t border-slate-700 pt-6 space-y-4">
                        {{-- DIRECTOR --}}
                        @php
                            $director = collect($movie['credits']['crew'])->firstWhere('job', 'Director');
                        @endphp
                        @if($director)
                            <div class="flex gap-4 border-b border-slate-800 pb-4">
                                <span class="font-bold text-white w-24">Dirección</span>
                                <a href="#" class="text-orange-400 hover:underline">{{ $director['name'] }}</a>
                            </div>
                        @endif

                        {{-- WRITERS --}}
                        @php
                            $writers = collect($movie['credits']['crew'])->whereIn('job', ['Screenplay', 'Writer', 'Story'])->take(3);
                        @endphp
                        @if($writers->count() > 0)
                            <div class="flex gap-4 border-b border-slate-800 pb-4">
                                <span class="font-bold text-white w-24">Guion</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($writers as $writer)
                                        <a href="#"
                                            class="text-orange-400 hover:underline">{{ $writer['name'] }}</a>@if(!$loop->last)
                                            <span class="text-slate-500">•</span> @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- CAST --}}
                        <div class="flex gap-4">
                            <span class="font-bold text-white w-24">Estrellas</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach(collect($movie['credits']['cast'])->take(3) as $actor)
                                    <a href="{{ route('actor.show', $actor['id']) }}"
                                        class="text-orange-400 hover:underline">{{ $actor['name'] }}</a>@if(!$loop->last)
                                        <span class="text-slate-500">•</span> @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- REVIEWS SECTION --}}
                    <div class="mt-12 border-t border-slate-700 pt-8">
                        <h3 class="text-2xl font-bold text-white mb-6">Reseñas de la Comunidad</h3>

                        {{-- Formulario para dejar reseña --}}
                        @auth
                            <form action="{{ route('reviews.store') }}" method="POST" class="mb-8 bg-[#2a2a2a] p-4 rounded-lg">
                                @csrf
                                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                <h4 class="text-lg font-semibold text-white mb-2">Escribe tu reseña</h4>
                                <textarea name="content" rows="3"
                                    class="w-full bg-[#1f1f1f] text-slate-200 border border-slate-600 rounded-lg p-3 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"
                                    placeholder="¿Qué te pareció esta película?" required></textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="submit"
                                        class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-lg transition">
                                        Publicar Reseña
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="mb-8 p-4 bg-slate-800/50 rounded-lg text-center">
                                <p class="text-slate-400">
                                    <a href="{{ route('login') }}" class="text-orange-400 hover:underline">Inicia sesión</a>
                                    para escribir una reseña.
                                </p>
                            </div>
                        @endauth

                        {{-- Lista de Reseñas --}}
                        <div class="space-y-6">
                            @if(isset($reviews) && count($reviews) > 0)
                                @foreach($reviews as $review)
                                    <div class="bg-[#2a2a2a] p-4 rounded-lg border border-slate-800">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-black font-bold text-xs">
                                                    {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-bold text-white block leading-none">{{ $review->user->name }}</span>
                                                    <span
                                                        class="text-xs text-slate-500">{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>

                                            @if(Auth::id() === $review->user_id)
                                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                                    onsubmit="return confirm('¿Borrar reseña?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-500 hover:text-red-500 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        <p class="text-slate-300 text-sm leading-relaxed">
                                            {{ $review->content }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-slate-500 italic">Aún no hay reseñas. ¡Sé el primero en opinar!</p>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
@endsection
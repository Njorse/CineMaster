<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CineMaster 🎬</title>
    <link rel="icon" href="{{ asset('img/logocine.png') }}" type="image/png">

    {{-- Vite (Laravel + Tailwind) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tipografía Montserrat (Google Fonts) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        .carousel-container {
            position: relative;
            overflow: hidden;
        }

        .carousel-slide {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .carousel-slide.active {
            display: block;
            opacity: 1;
        }

        .carousel-dot {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background-color: #ff8c00;
            width: 24px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.875rem;
            }

            .hero-rating {
                font-size: 1.25rem;
            }

            .carousel-button {
                padding: 0.5rem;
                font-size: 1.25rem;
            }

            .hero-content {
                max-width: 100%;
            }
        }

        @media (max-width: 640px) {
            .hero-title {
                font-size: 1.5rem;
            }

            .hero-rating {
                font-size: 1rem;
            }

            .hero-description {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }

            .carousel-button {
                padding: 0.375rem;
                font-size: 1rem;
            }

            .filter-buttons {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .filter-buttons button {
                font-size: 0.75rem;
                padding: 0.375rem 0.75rem;
            }
        }

        /* Force hide mobile menu button on desktop */
        @media (min-width: 768px) {
            .mobile-menu-button {
                display: none !important;
            }
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-[#0f0f0f] via-[#1a1a1a] to-[#0d0d0d] text-white font-[Montserrat] flex flex-col min-h-screen">

    {{-- Header --}}
    <header x-data="{ openMenu: false, mobileMenu: false }"
        class="w-full border-b border-slate-700/50 bg-[#0d0d0d]/90 backdrop-blur-sm relative z-50">

        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- LOGO --}}
                <a href="{{ route('home') }}"
                    class="text-2xl font-extrabold bg-orange-500 bg-clip-text text-transparent tracking-tight">
                    🎬 CineMaster
                </a>

                {{-- DESKTOP NAV --}}
                @if (Route::has('login'))
                    <nav class="hidden md:flex items-center gap-3 text-sm">
                        @auth
                            <a href="{{ route('favoritos') }}" class="px-4 py-2 bg-orange-500 text-black font-semibold border border-orange-500 
                                                      hover:bg-orange-600 hover:border-orange-600 
                                                      rounded-lg transition duration-200">
                                Favoritos
                            </a>

                            <a href="{{ route('recommendations') }}" class="px-4 py-2 bg-orange-500 text-black font-semibold border border-orange-500 
                                                      hover:bg-orange-600 hover:border-orange-600 
                                                      rounded-lg transition duration-200">
                                Recomendaciones
                            </a>

                            {{-- MENU USUARIO --}}
                            <div class="relative">
                                <button @click="openMenu = !openMenu"
                                    class="px-4 py-2 bg-slate-800/50 hover:bg-slate-700/50 rounded-lg transition flex items-center gap-2 text-white">
                                    {{ Auth::user()->name }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="openMenu" @click.away="openMenu = false"
                                    class="absolute right-0 mt-2 w-48 bg-[#1a1a1a] border border-slate-700 rounded-lg shadow-xl z-[9999]"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    style="display: none;">

                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-slate-300 hover:bg-slate-700 hover:text-white rounded-t-lg transition">
                                        👤 Perfil
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-red-400 hover:bg-slate-700 hover:text-red-300 rounded-b-lg transition">
                                            🚪 Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="px-4 py-2 text-slate-300 hover:text-white transition font-medium">
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-orange-500 text-black font-semibold border border-orange-500 
                                              hover:bg-orange-600 hover:border-orange-600 
                                              rounded-lg transition duration-200">
                                    Registrarse
                                </a>
                            @endif
                        @endguest
                    </nav>

                    {{-- MOBILE MENU BUTTON --}}
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden mobile-menu-button text-slate-300 hover:text-white p-2 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenu" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>

            {{-- MOBILE MENU DROPDOWN --}}
            <div x-show="mobileMenu" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden mt-4 pb-4 border-t border-slate-700/50 pt-4 space-y-4"
                 style="display: none;">
                
                @auth
                    <div class="flex flex-col gap-2">
                        <div class="px-2 py-2 text-sm text-slate-400 font-semibold uppercase tracking-wider">
                            Menú de {{ Auth::user()->name }}
                        </div>
                        <a href="{{ route('favoritos') }}" class="block px-4 py-2 bg-slate-800/50 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition">
                            ★ Favoritos
                        </a>
                        <a href="{{ route('recommendations') }}" class="block px-4 py-2 bg-slate-800/50 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition">
                            ⚡ Recomendaciones
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 bg-slate-800/50 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition">
                            👤 Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition">
                                🚪 Cerrar sesión
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-slate-600 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                            Iniciar sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-orange-500 text-black font-bold rounded-lg hover:bg-orange-600 transition">
                                Registrarse
                            </a>
                        @endif
                    </div>
                @endguest
            </div>
        </div>
    </header>


    {{-- Main --}}
    <main class="flex-1 flex flex-col">
        {{-- Carrusel Hero --}}
        @if (!empty($movies))
            <div class="carousel-container relative h-96 md:h-[480px] overflow-hidden group">
                @foreach (array_slice($movies, 0, 5) as $index => $movie)
                    <div class="carousel-slide {{ $index === 0 ? 'active' : '' }} absolute inset-0">
                        <div class="absolute inset-0">
                            <img src="https://image.tmdb.org/t/p/w1280{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                alt="{{ $movie['title'] }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#0f0f0f] via-[#0f0f0f]/50 to-transparent"></div>
                        </div>

                        {{-- Contenido Hero --}}
                        <div class="absolute inset-0 flex items-center px-6 md:px-12">
                            <div class="max-w-2xl z-10">
                                <div class="flex items-center gap-3 mb-4">
                                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-100">{{ $movie['title'] }}</h2>
                                    <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">HD</span>
                                </div>

                                <div class="flex items-center gap-3 mb-6">
                                    <span
                                        class="text-2xl font-bold text-orange-400">{{ number_format($movie['vote_average'], 1) }}/10</span>
                                    <div class="flex gap-1">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < round($movie['vote_average'] / 2))
                                                <span class="text-orange-400">★</span>
                                            @else
                                                <span class="text-slate-600">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                <p class="text-slate-300 mb-8 line-clamp-3 text-sm md:text-base">{{ $movie['overview'] }}</p>

                                <a href="{{ route('movie.show', $movie['id']) }}"
                                    class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold px-8 py-3 rounded-full transition-all duration-300 shadow-lg shadow-orange-900/50">
                                    ▶ Ver mas
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Controles Carousel --}}
                <button onclick="carouselPrev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-slate-700/60 hover:bg-slate-600 rounded-full transition text-slate-200">
                    ❮
                </button>
                <button onclick="carouselNext()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-2 bg-slate-700/60 hover:bg-slate-600 rounded-full transition text-slate-200">
                    ❯
                </button>

                {{-- Indicadores Carousel --}}
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                    @foreach (array_slice($movies, 0, 5) as $i => $movie)
                        <div class="carousel-dot {{ $i === 0 ? 'active' : '' }} w-2 h-2 rounded-full bg-slate-600 cursor-pointer transition-all"
                            onclick="currentSlide({{ $i }})"></div>
                    @endforeach
                </div>
            </div>
        @endif


        {{-- SECCIÓN: TAQUILLA (Top Revenue) --}}
        @if(isset($topRevenue) && count($topRevenue) > 0)
            <div class="max-w-7xl mx-auto px-6 py-4 mb-8">
                <h3 class="text-xl font-bold text-slate-100 mb-6 flex items-center gap-2">
                    <span class="text-orange-500">|</span> Películas más taquilleras (EE. UU.)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($topRevenue as $index => $movie)
                        <div class="flex items-center gap-4 bg-[#1a1a1a] p-4 rounded-xl border border-slate-800 hover:border-orange-500/30 transition-all group">
                            <span class="text-4xl font-black text-slate-700 group-hover:text-orange-500/50 transition-colors">
                                {{ $index + 1 }}
                            </span>
                            
                            <div class="w-12 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-slate-800">
                                @if(isset($movie['poster_path']))
                                    <img src="https://image.tmdb.org/t/p/w92{{ $movie['poster_path'] }}" 
                                         alt="{{ $movie['title'] }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="text-slate-200 font-bold text-sm truncate group-hover:text-orange-400 transition-colors">
                                    {{ $movie['title'] }}
                                </h4>
                                <p class="text-slate-500 text-xs mt-1">
                                    @if(isset($movie['revenue']) && $movie['revenue'] > 0)
                                        <span class="text-green-500 font-mono font-bold">${{ number_format($movie['revenue'] / 1000000, 1) }} M</span>
                                    @else
                                        <span class="text-slate-600">Ingresos no disp.</span>
                                    @endif
                                </p>
                            </div>

                            <a href="{{ route('movie.show', $movie['id']) }}" class="p-2 text-slate-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- SECCIÓN: CELEBRIDADES (Carousel) --}}
        @if(isset($actors) && count($actors) > 0)
            <div class="max-w-7xl mx-auto px-6 py-8 relative group" x-data>
                <h3 class="text-xl font-bold text-slate-100 mb-6 flex items-center gap-2">
                    <span class="text-orange-500">|</span> Celebridades más populares
                </h3>
                
                <div class="relative">
                    {{-- Botón Izquierda --}}
                    <button @click="$refs.actorsScroll.scrollBy({ left: -300, behavior: 'smooth' })"
                            class="absolute left-0 top-1/2 -translate-y-1/2 z-10 p-2 bg-black/50 hover:bg-black/80 text-white rounded-full opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>

                    {{-- Contenedor Scroll --}}
                    <div x-ref="actorsScroll" 
                         class="flex overflow-x-auto gap-6 pb-4 scrollbar-hide scroll-smooth"
                         style="scrollbar-width: none; -ms-overflow-style: none;">
                        <style>.scrollbar-hide::-webkit-scrollbar { display: none; }</style>
                        
                        @foreach($actors as $actor)
                            <a href="{{ route('actor.show', $actor['id']) }}" class="flex-shrink-0 flex flex-col items-center gap-2 w-24 group/actor cursor-pointer">
                                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-slate-700 group-hover/actor:border-orange-500 transition-all">
                                    @if($actor['profile_path'])
                                        <img src="https://image.tmdb.org/t/p/w185{{ $actor['profile_path'] }}" 
                                             alt="{{ $actor['name'] }}" 
                                             class="w-full h-full object-cover group-hover/actor:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-slate-800 flex items-center justify-center text-slate-500">
                                            ?
                                        </div>
                                    @endif
                                </div>
                                <span class="text-xs text-center text-slate-300 group-hover/actor:text-orange-400 transition-colors line-clamp-2">
                                    {{ $actor['name'] }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    {{-- Botón Derecha --}}
                    <button @click="$refs.actorsScroll.scrollBy({ left: 300, behavior: 'smooth' })"
                            class="absolute right-0 top-1/2 -translate-y-1/2 z-10 p-2 bg-black/50 hover:bg-black/80 text-white rounded-full opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </button>
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto w-full px-3 sm:px-6 py-8 sm:py-12">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-100">Películas</h3>
                
                {{-- BUSCADOR HOME --}}
                <form action="{{ route('search') }}" method="GET" class="w-full sm:w-auto flex-1 max-w-md flex items-center bg-slate-800/50 border border-slate-700 rounded-full px-4 py-2 focus-within:ring-2 focus-within:ring-orange-500/50 transition-all">
                    <svg class="w-5 h-5 text-slate-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="query" placeholder="¿Qué quieres ver hoy?" 
                           class="bg-transparent border-none text-slate-200 placeholder-slate-500 text-sm w-full focus:ring-0 p-0"
                           autocomplete="off">
                </form>

                <div class="filter-buttons flex gap-2 flex-wrap">
                    <a href="{{ route('home', ['filter' => 'ultimas']) }}"
                        class="px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition {{ ($filter ?? 'populares') === 'ultimas' ? 'text-white bg-orange-500 hover:bg-orange-600' : 'text-slate-300 hover:text-white bg-slate-800' }}">
                        Últimas
                    </a>
                    <a href="{{ route('home', ['filter' => 'populares']) }}"
                        class="px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition {{ ($filter ?? 'populares') === 'populares' ? 'text-white bg-orange-500 hover:bg-orange-600' : 'text-slate-300 hover:text-white bg-slate-800' }}">
                        Populares
                    </a>
                    <a href="{{ route('home', ['filter' => 'proximamente']) }}"
                        class="px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition {{ ($filter ?? 'populares') === 'proximamente' ? 'text-white bg-orange-500 hover:bg-orange-600' : 'text-slate-300 hover:text-white bg-slate-800' }}">
                        Próximamente
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @if (!empty($movies))
                    @foreach ($movies as $movie)
                        <a href="{{ route('movie.show', $movie['id']) }}" class="group flex flex-col">
                            <div
                                class="relative overflow-hidden rounded-lg shadow-lg transition-all duration-300 hover:scale-105 bg-slate-800">
                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                    alt="{{ $movie['title'] }}" class="w-full h-96 object-cover">
                                <span
                                    class="absolute top-3 right-3 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded">2025</span>
                            </div>
                            <div class="mt-3">
                                <h4 class="text-slate-100 font-semibold text-sm line-clamp-2 mb-2">{{ $movie['title'] }}</h4>
                                <div class="flex items-center gap-2">
                                    <span class="text-orange-400 font-bold text-sm">⭐
                                        {{ number_format($movie['vote_average'], 1) }}</span>
                                    <span class="text-xs text-slate-400">/10</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>

            {{-- Paginación --}}
            @if($totalPages > 1)
                <div class="flex justify-center items-center gap-2 mt-12 flex-wrap">
                    <a href="{{ route('home', ['page' => max(1, $currentPage - 1), 'filter' => $filter ?? 'populares']) }}"
                        class="text-xs p-2 rounded-lg border border-slate-600/50 hover:border-slate-400 hover:bg-slate-500/10 transition text-slate-300">
                        ← Anterior
                    </a>

                    <div class="flex gap-1">
                        @for($i = 1; $i <= min($totalPages, 7); $i++)
                            <a href="{{ route('home', ['page' => $i, 'filter' => $filter ?? 'populares']) }}"
                                class="px-3 py-2 rounded-lg font-semibold transition-all {{ $currentPage == $i ? 'bg-orange-500 text-white shadow-lg shadow-orange-900/50' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                                {{ $i }}
                            </a>
                        @endfor
                    </div>

                    <a href="{{ route('home', ['page' => min($totalPages, $currentPage + 1), 'filter' => $filter ?? 'populares']) }}"
                        class="text-xs p-2 rounded-lg border border-slate-600/50 hover:border-slate-400 hover:bg-slate-500/10 transition text-slate-300">
                        Siguiente →
                    </a>
                </div>
            @endif
        </div>
    </main>

    <x-footer />

    <script>
        let currentSlideIndex = 0;
        const totalSlides = document.querySelectorAll('.carousel-slide').length;

        function showSlide(n) {
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');

            if (n >= totalSlides) currentSlideIndex = 0;
            if (n < 0) currentSlideIndex = totalSlides - 1;

            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[currentSlideIndex].classList.add('active');
            dots[currentSlideIndex].classList.add('active');
        }

        function carouselNext() {
            currentSlideIndex++;
            showSlide(currentSlideIndex);
        }

        function carouselPrev() {
            currentSlideIndex--;
            showSlide(currentSlideIndex);
        }

        function currentSlide(n) {
            currentSlideIndex = n;
            showSlide(currentSlideIndex);
        }

        // Auto-avance cada 6 segundos
        setInterval(carouselNext, 6000);
    </script>

</body>

</html>
<header x-data="{ openMenu: false, mobileMenu: false }"
    class="w-full border-b border-slate-700/50 bg-[#0d0d0d] relative z-50">

    <style>
        @media (min-width: 768px) {
            .mobile-menu-button {
                display: none !important;
            }
        }
    </style>

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
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                style="display: none;">

                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-3 text-slate-300 hover:bg-slate-700 hover:text-white rounded-t-lg transition">
                                    👤 Perfil
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 text-red-400 hover:bg-slate-700 hover:text-red-300 rounded-b-lg transition">
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
                <button @click="mobileMenu = !mobileMenu"
                    class="md:hidden mobile-menu-button text-slate-300 hover:text-white p-2 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenu" style="display: none;" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>

        {{-- MOBILE MENU DROPDOWN --}}
        <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden mt-4 pb-4 border-t border-slate-700/50 pt-4 space-y-4" style="display: none;">

            @auth
                <div class="flex flex-col gap-2">
                    <div class="px-2 py-2 text-sm text-slate-400 font-semibold uppercase tracking-wider">
                        Menú de {{ Auth::user()->name }}
                    </div>
                    <a href="{{ route('favoritos') }}"
                        class="block px-4 py-2 bg-slate-800/50 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition">
                        ★ Favoritos
                    </a>
                    <a href="{{ route('recommendations') }}"
                        class="block px-4 py-2 bg-slate-800/50 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition">
                        ⚡ Recomendaciones
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 bg-slate-800/50 rounded-lg text-slate-200 hover:bg-slate-700 hover:text-white transition">
                        👤 Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition">
                            🚪 Cerrar sesión
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="flex flex-col gap-3">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center px-4 py-2 border border-slate-600 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                        Iniciar sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-4 py-2 bg-orange-500 text-black font-bold rounded-lg hover:bg-orange-600 transition">
                            Registrarse
                        </a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</header>
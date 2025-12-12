<nav x-data="{ open: false }" class="bg-[#111] border-b border-orange-600 text-white shadow-lg">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-orange-500" />
                    </a>
                </div>

                <!-- Navigation Links (solo para usuarios logueados) -->
                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                        {{-- FAVORITOS --}}
                        <x-nav-link :href="route('favoritos')" :active="request()->routeIs('favoritos')"
                            class="text-orange-400 hover:text-orange-500 transition">
                            {{ __('Favoritos') }}
                        </x-nav-link>

                    </div>
                @endauth
            </div>

            <!-- Right side -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">

                {{-- Si NO está logueado: Login / Register --}}
                @guest
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="px-4 py-1.5 text-sm font-medium text-orange-500 border border-orange-500/50 rounded-full hover:bg-orange-500 hover:text-white transition-all duration-300">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-1.5 text-sm font-medium text-white bg-gradient-to-r from-orange-600 to-orange-500 rounded-full hover:shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-0.5 transition-all duration-300">
                            Register
                        </a>
                    </div>
                @endguest

                {{-- Si está logueado: menú del usuario --}}
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-orange-100 bg-white/5 border border-white/10 rounded-full hover:bg-white/10 hover:border-orange-500/50 transition-all duration-300 focus:outline-none">
                                <div class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></div>
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1 text-orange-500">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content" class="bg-[#1a1a1a] text-white border border-orange-600">
                            <x-dropdown-link :href="route('profile.edit')">
                                Perfil
                            </x-dropdown-link>

                            <!-- Cerrar sesión -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

            </div>

            <!-- Hamburger (mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-md text-orange-400 hover:text-orange-300 hover:bg-orange-500/20 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#1a1a1a] border-t border-orange-600">

        <!-- LINKS MOBILE SOLO PARA LOGUEADOS -->
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('favoritos')" :active="request()->routeIs('favoritos')">
                    Favoritos
                </x-responsive-nav-link>
            </div>
        @endauth

        <!-- MOBILE SETTINGS -->
        <div class="pt-4 pb-1 border-t border-orange-600">
            @guest
                <div class="px-4 flex flex-col gap-1">
                    <a href="{{ route('login') }}" class="text-orange-400">Login</a>
                    <a href="{{ route('register') }}" class="text-orange-400">Register</a>
                </div>
            @endguest

            @auth
                <div class="px-4 text-orange-400">
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Perfil
                    </x-responsive-nav-link>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth
        </div>
    </div>

</nav>
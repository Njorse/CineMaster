<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Bienvenido de nuevo</h2>
        <p class="text-slate-400 text-sm">Ingresa tus credenciales para acceder</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">

            </div>
            <input id="email"
                class="block w-full  pr-4 py-3 bg-[#0f0f0f] border border-slate-700 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300 sm:text-sm"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Correo electrónico" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">

            </div>
            <input id="password"
                class="block w-full  pr-4 py-3 bg-[#0f0f0f] border border-slate-700 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300 sm:text-sm"
                type="password" name="password" required autocomplete="current-password" placeholder="Contraseña" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-sm">


            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-orange-500 hover:text-orange-400 font-medium transition-colors">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-orange-900/20 text-sm font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-orange-500 transition-all duration-300 transform hover:-translate-y-0.5">
            {{ __('Iniciar Sesión') }}
        </button>

        <!-- Register Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-slate-500">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}"
                    class="text-white font-semibold hover:text-orange-500 transition-colors">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
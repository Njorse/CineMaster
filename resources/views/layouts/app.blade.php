<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CineMaster') }}</title>
    <link rel="icon" href="{{ asset('img/logocine.png') }}" type="image/png">

    <!-- Fuentes: Cargando Montserrat para todo el proyecto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Aplicamos la fuente y el fondo oscuro (Dark Mode) al cuerpo --}}

<body class="font-[Montserrat] antialiased bg-[#0f0f0f] text-white">
    <div class="min-h-screen">
        <x-headerPro />


        <!-- Page Content (Contenido Principal) -->
        {{-- CORRECCIÓN: Quitamos el 'div' extra y el 'py-6 px-4...' para que la vista hija lo defina --}}
        <main>
            {{-- Esta es la ÚNICA llamada. Aquí se insertará el contenido de @section('content') --}}
            @yield('content')
        </main>

        <x-footer />

    </div>
</body>

</html>
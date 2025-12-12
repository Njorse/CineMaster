<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\View\View;

class ActorController extends Controller
{
    public function show($id): View
    {
        // 1. Obtener detalles del actor (Bio, fecha nacimiento, etc.)
        $actor = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/person/{$id}", [
                'language' => 'es-ES',
            ])->json();

        // 2. Obtener películas donde ha actuado (Combined credits para incluir TV si quisieras, 
        // pero movie_credits es mejor si solo enfocas en cine)
        $credits = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/person/{$id}/movie_credits", [
                'language' => 'es-ES',
            ])->json();

        // Ordenar por popularidad descendente para mostrar las más famosas primero
        $movies = collect($credits['cast'] ?? [])
            ->sortByDesc('popularity')
            ->take(20); // Top 20 películas

        return view('actor.show', compact('actor', 'movies'));
    }
}

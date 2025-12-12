<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;
use App\Models\Calificacion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Importante
use App\Models\Pelicula; // Lo dejamos, es buena práctica

class PeliculaController extends Controller
{
    /**
     * Muestra la lista de películas populares (Catálogo principal).
     */
    public function index()
    {
        // AJUSTE CLAVE: Usar withToken para autenticación de API, como en tu HomeController
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/movie/popular", [
                'language' => 'es-ES',
            ]);

        $peliculasPopulares = $response->json()['results'];

        return view('home', [
            'peliculas' => $peliculasPopulares
        ]);
    }

    /**
     * Muestra el detalle de una película específica.
     */
    public function show($id)
    {
        $movie = $this->tmdbService->getMovieDetails($id);

        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Favorito::where('user_id', Auth::id())
                ->where('tmdb_id', $id)
                ->exists();
        }

        // ⭐⭐ ESTA PARTE ES LA QUE TE FALTA ⭐⭐
        $userRating = null;

        if (Auth::check()) {
            $localMovie = Pelicula::where('tmdb_id', $id)->first();

            if ($localMovie) {
                $userRating = Calificacion::where('user_id', Auth::id())
                    ->where('pelicula_id', $localMovie->id)
                    ->value('rating');
            }
        }

        return view('movie.show', [
            'movie' => $movie,
            'isFavorite' => $isFavorite,
            'userRating' => $userRating, // ← EL VALOR QUE NECESITA LA VISTA
        ]);
    }




}
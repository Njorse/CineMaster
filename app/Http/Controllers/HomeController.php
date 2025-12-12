<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache; // Importar Cache
use Illuminate\Support\Facades\Auth; // Necesario para saber si el usuario está logueado
use App\Models\Pelicula; // Necesario para buscar en tu tabla local
use App\Models\Calificacion; // <--- ¡IMPORTADO PARA BUSCAR EL RATING!

class HomeController extends Controller
{
    public function home(Request $request): View
    {
        $page = $request->query('page', 1);
        $filter = $request->query('filter', 'populares'); // Default: populares

        // Mapear el filtro al endpoint de TMDB
        $endpoint = match ($filter) {
            'ultimas' => 'movie/now_playing',
            'proximamente' => 'movie/upcoming',
            default => 'movie/popular',
        };

        // Cachear la lista principal de películas (60 minutos)
        $cacheKeyMovies = "home_movies_{$filter}_{$page}";
        $moviesData = Cache::remember($cacheKeyMovies, 60 * 60, function () use ($endpoint, $page) {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get("https://api.themoviedb.org/3/{$endpoint}", [
                    'language' => 'es-ES',
                    'page' => $page
                ]);
            return [
                'results' => $response->json()['results'] ?? [],
                'total_pages' => $response->json()['total_pages'] ?? 1
            ];
        });

        $movies = $moviesData['results'];
        $totalPages = $moviesData['total_pages'];
        $currentPage = (int) $page;

        // Nuevas secciones (Cachear por 60 minutos)
        $actors = Cache::remember('home_popular_actors', 60 * 60, function () {
            return $this->getPopularActors();
        });

        $topRevenue = Cache::remember('home_top_revenue', 60 * 60, function () {
            return $this->getTopRevenueMovies();
        });

        return view('home', compact('movies', 'totalPages', 'currentPage', 'filter', 'actors', 'topRevenue'));
    }

    private function getPopularActors()
    {
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/person/popular', [
                'language' => 'es-ES',
                'page' => 1
            ]);

        return $response->json()['results'] ?? [];
    }

    private function getTopRevenueMovies()
    {
        // 1. Obtener lista de películas con mayores ingresos
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get('https://api.themoviedb.org/3/discover/movie', [
                'language' => 'es-ES',
                'sort_by' => 'revenue.desc',
                'page' => 1
            ]);

        $movies = $response->json()['results'] ?? [];

        // Limitamos a 5 para no saturar
        $top5 = array_slice($movies, 0, 5);
        $detailedMovies = [];

        foreach ($top5 as $movie) {
            $detail = Http::withToken(env('TMDB_TOKEN'))
                ->get("https://api.themoviedb.org/3/movie/{$movie['id']}", [
                    'language' => 'es-ES'
                ])->json();

            if (isset($detail['revenue']) && $detail['revenue'] > 0) {
                $detailedMovies[] = $detail;
            }
        }

        return $detailedMovies;
    }


    public function show($id): View
    {
        // 1. Obtener detalles de la película de la API
        $response = Http::withToken(env('TMDB_TOKEN'))
            ->get("https://api.themoviedb.org/3/movie/{$id}?language=es-ES&append_to_response=videos,credits,images");

        $movie = $response->json();

        // 2. LÓGICA PARA VERIFICAR EL ESTADO (Favoritos y Calificación)
        $isFavorite = false;
        $userRating = 0; // <--- Inicializamos la calificación a 0

        if (Auth::check()) {

            // A. Buscar si la película existe en la BBDD local por su ID de TMDB
            $peliculaLocal = Pelicula::where('tmdb_id', $movie['id'])->first();

            if ($peliculaLocal) {
                // B. 1. Verificar si es favorita (igual que antes)
                $isFavorite = Auth::user()->favoritos()
                    ->where('pelicula_id', $peliculaLocal->id)
                    ->exists();

                // B. 2. OBTENER CALIFICACIÓN GUARDADA (¡LA PARTE FALTANTE!)
                $calificacionExistente = Auth::user()->calificaciones()
                    ->where('pelicula_id', $peliculaLocal->id)
                    ->first();

                if ($calificacionExistente) {
                    $userRating = $calificacionExistente->rating; // Asignamos el valor guardado
                }
            }
        }










        // 3. Obtener Reseñas
        $reviews = \App\Models\Review::where('tmdb_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // 4. Pasar variables a la vista
        return view('movie.show', compact('movie', 'isFavorite', 'userRating', 'reviews'));
    }


    // --- NUEVA FUNCIÓN DE RECOMENDACIONES ---
    public function recomendaciones(): View
    {
        $recomendaciones = [];
        $mensaje = "Inicia sesión y agrega favoritos para ver recomendaciones.";
        $mensajeSufijo = "";

        if (Auth::check()) {
            // 1. Buscar la última película interactuada
            $ultimaInteraccion = Auth::user()->calificaciones()
                ->orderBy('created_at', 'desc')->with('pelicula')->first();

            if (!$ultimaInteraccion) {
                $ultimaInteraccion = Auth::user()->favoritos()
                    ->orderBy('created_at', 'desc')->with('pelicula')->first();
            }

            if ($ultimaInteraccion) {
                $tmdbId = $ultimaInteraccion->pelicula->tmdb_id;
                $tituloBase = $ultimaInteraccion->pelicula->titulo;

                // 2. INTENTO A: Recomendaciones directas de TMDB
                $response = Http::withToken(env('TMDB_TOKEN'))
                    ->get("https://api.themoviedb.org/3/movie/{$tmdbId}/recommendations", [
                        'language' => 'es-ES',
                        'page' => 1
                    ]);

                $recomendaciones = $response->json()['results'] ?? [];

                // 3. INTENTO B: Si no hay directas, BUSCAR POR GÉNERO (Fallback)
                if (count($recomendaciones) == 0) {
                    // A. Pedimos los detalles de la peli base para sacar sus géneros
                    $detallePeli = Http::withToken(env('TMDB_TOKEN'))
                        ->get("https://api.themoviedb.org/3/movie/{$tmdbId}", [
                            'language' => 'es-ES',
                        ])->json();

                    if (isset($detallePeli['genres']) && count($detallePeli['genres']) > 0) {
                        $generoId = $detallePeli['genres'][0]['id']; // Tomamos el primer género principal
                        $nombreGenero = $detallePeli['genres'][0]['name'];

                        // B. Buscamos películas populares de ese género
                        $responseGenero = Http::withToken(env('TMDB_TOKEN'))
                            ->get("https://api.themoviedb.org/3/discover/movie", [
                                'language' => 'es-ES',
                                'with_genres' => $generoId,
                                'sort_by' => 'popularity.desc', // Las más populares
                                'page' => 1
                            ]);

                        $recomendaciones = $responseGenero->json()['results'] ?? [];

                        if (count($recomendaciones) > 0) {
                            $mensaje = "Como te gustó";
                            $mensajeSufijo = ", te sugerimos éxitos de {$nombreGenero}:";
                        }
                    }
                } else {
                    $mensaje = "Porque te gustó";
                    $mensajeSufijo = ", te recomendamos:";
                }

                if (count($recomendaciones) == 0) {
                    $mensaje = "No encontramos recomendaciones similares a";
                    $mensajeSufijo = " por ahora.";
                }

            } else {
                $mensaje = "Aún no tienes actividad. Califica o agrega películas a favoritos para recibir sugerencias.";
            }
        }

        return view('movie.recommendations', compact('recomendaciones', 'mensaje', 'ultimaInteraccion', 'mensajeSufijo'));
    }

    public function search(Request $request): View
    {
        $query = $request->input('query');
        $movies = [];

        if ($query) {
            $response = Http::withToken(env('TMDB_TOKEN'))
                ->get('https://api.themoviedb.org/3/search/movie', [
                    'query' => $query,
                    'language' => 'es-ES',
                    'page' => 1
                ]);

            $movies = $response->json()['results'] ?? [];
        }

        return view('movie.search', compact('movies', 'query'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Necesitas esto para saber quién está logueado

class FavoritoController extends Controller
{
    public function index()
{
    // 1. Usa la relación 'favoritos' del usuario logueado
    // El método with('pelicula') es clave para traer la info del póster y título
    $favoritos = Auth::user()->favoritos()->with('pelicula')->get();

    // 2. Manda la lista de Favoritos a la vista movie.favorites
    return view('movie.favorites', compact('favoritos'));
}
    // Solo necesitamos la función store() para guardar/quitar
    public function store(Request $request)
    {
        // 1. Valida que el ID de TMDB sea un número (lo mínimo de seguridad)
        $request->validate(['tmdb_id' => 'required|integer']); 

        // 2. Busca o crea la película en tu tabla local 'peliculas'
        // Esto es CLAVE: garantiza que tengas un registro local antes de crear el favorito
        $pelicula = Pelicula::firstOrCreate(
            ['tmdb_id' => $request->tmdb_id], 
            [
                'titulo' => $request->titulo, 
                'poster_path' => $request->poster_path,
                // Puedes agregar más campos aquí si los envías desde la vista
            ]
        );

        $userId = Auth::id(); // Obtiene el ID del usuario actual

        // 3. Busca si el usuario ya tiene esta película como favorita (el 'toggle')
        $favoritoExistente = Favorito::where('user_id', $userId)
                                     ->where('pelicula_id', $pelicula->id)
                                     ->first();

        if ($favoritoExistente) {
            // 4. Si EXISTE, lo borra (Quitar favorito)
            $favoritoExistente->delete();
            return back()->with('info', 'Película quitada de favoritos.');
        } else {
            // 5. Si NO EXISTE, lo crea (Guardar favorito)
            Favorito::create([
                'user_id' => $userId,
                'pelicula_id' => $pelicula->id,
            ]);
            return back()->with('success', '¡Película guardada en favoritos!');
        }
    }
}
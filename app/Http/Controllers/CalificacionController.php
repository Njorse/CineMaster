<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Para usar Carbon::now()

class CalificacionController extends Controller
{
    /**
     * Guarda o actualiza la calificación de una película.
     */
    public function store(Request $request)
    {
        // 1. Validar
        $data = $request->validate([
            'tmdb_id' => 'required',
            'titulo' => 'required',
            'poster_path' => 'required',
            'rating' => 'required|integer|min:0|max:5',
        ]);

        // 2. Buscar o crear película
        $pelicula = Pelicula::firstOrCreate(
            ['tmdb_id' => $data['tmdb_id']],
            [
                'titulo' => $data['titulo'],
                'poster_path' => $data['poster_path'],
            ]
        );

        // 3. Crear, actualizar o eliminar calificación
        if ($data['rating'] == 0) {
            Calificacion::where('user_id', auth()->id())
                ->where('pelicula_id', $pelicula->id)
                ->delete();

            return back()->with('success', 'Calificación eliminada');
        }

        Calificacion::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'pelicula_id' => $pelicula->id,
            ],
            [
                'rating' => $data['rating'],
            ]
        );

        return back()->with('success', 'Calificación guardada');
    }

}
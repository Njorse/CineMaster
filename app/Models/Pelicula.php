<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelicula extends Model
{
    use HasFactory;

    // 1. Los campos que llenas desde la API
    protected $fillable = [
        'tmdb_id',
        'titulo',
        'descripcion',
        'poster_path',
        'fecha_lanzamiento',
    ];

    // 2. Relaciones (para que puedas hacer $pelicula->favoritos)
    public function favoritos()
    {
        return $this->hasMany(Favorito::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
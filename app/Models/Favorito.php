<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    use HasFactory;

    // 1. Los campos que se llenan
    protected $fillable = [
        'user_id',
        'pelicula_id',
    ];

    // 2. Relaciones (para saber de quién es)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;
    protected $table = 'calificaciones';
    
    // CRUCIAL: ESTO FUERZA A LARAVEL A TRATAR LAS LLAVES FORÁNEAS COMO NÚMEROS ENTEROS, 
    // LO CUAL ES NECESARIO PARA QUE updateOrCreate FUNCIONE AL BUSCAR UN REGISTRO EXISTENTE.
    protected $casts = [
        'user_id' => 'integer',
        'pelicula_id' => 'integer',
        'rating' => 'integer',
    ];

     protected $fillable = [
    'user_id',
    'pelicula_id',
    'rating'
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }
}
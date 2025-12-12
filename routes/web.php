<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\CalificacionController;


// Rutas Públicas (Cualquiera puede ver)
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/pelicula/{id}', [HomeController::class, 'show'])->name('movie.show');
Route::get('/buscar', [HomeController::class, 'search'])->name('search');
Route::get('/actor/{id}', [App\Http\Controllers\ActorController::class, 'show'])->name('actor.show');


// RUTAS AUTENTICADAS (SÓLO PARA USUARIOS LOGUEADOS)
Route::middleware('auth')->group(function () {

    // RUTA 1: Ver lista de Favoritos (Protegida)
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos');

    Route::get('/recomendaciones', [HomeController::class, 'recomendaciones'])->name('recommendations');



    // RUTA 2: Acción de guardar/quitar Favoritos (POST)
    Route::post('/favoritos/toggle', [FavoritoController::class, 'store'])->name('favoritos.toggle');

    // RUTA 3: Acción de Calificaciones (POST)
    Route::post('/calificar', [CalificacionController::class, 'store'])->name('calificaciones.store');

    // RUTA 4: Reseñas
    Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Rutas de Dashboard y Perfil (Breeze)
    // Dashboard eliminado por redundancia


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
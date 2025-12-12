<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('favoritos', function (Blueprint $table) {
        $table->id();
        
        // --- COLUMNAS DE RELACIÓN ---
        // 1. user_id (Llave foránea al usuario)
        $table->foreignId('user_id')
              ->constrained('users') // Conectado a la tabla 'users'
              ->onDelete('cascade'); // Si borras el usuario, se borran sus favoritos

        // 2. pelicula_id (Llave foránea a tu tabla 'peliculas')
        $table->foreignId('pelicula_id')
              ->constrained('peliculas') // Conectado a la tabla 'peliculas'
              ->onDelete('cascade');
        // ---------------------------

        $table->timestamps();

        // OPCIONAL: Asegura que un usuario solo pueda tener una película favorita UNA vez.
        $table->unique(['user_id', 'pelicula_id']); 
    });
}
};

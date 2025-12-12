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
    Schema::create('calificaciones', function (Blueprint $table) {
        $table->id();
        
        // --- COLUMNAS DE RELACIÓN (CRÍTICAS) ---
        $table->foreignId('user_id')
              ->constrained('users') // Conectado a la tabla 'users'
              ->onDelete('cascade'); 

        $table->foreignId('pelicula_id')
              ->constrained('peliculas') // Conectado a la tabla 'peliculas'
              ->onDelete('cascade');
        
        $table->unsignedTinyInteger('rating'); // El valor de 1 a 5
        // ---------------------------

        $table->timestamps();

        // Asegura que un usuario solo pueda calificar una película UNA vez.
        $table->unique(['user_id', 'pelicula_id']); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};

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
    Schema::create('peliculas', function (Blueprint $table) {
        $table->id();
        
        // --- COLUMNAS PARA GUARDAR DATOS DE LA API ---
        
        // Este es el ID de TMDB (CRÍTICO)
        $table->unsignedBigInteger('tmdb_id')->unique(); 
        
        // Datos básicos
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        $table->string('poster_path')->nullable();
        $table->date('fecha_lanzamiento')->nullable(); 
        
        // --------------------------------------------
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peliculas');
    }
};

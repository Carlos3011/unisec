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
        // Crear primero la tabla padre
        Schema::create('seccion_noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->timestamps();
            $table->softDeletes();
        });

        // Luego crear la tabla que tiene la clave foránea
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seccion_noticias_id')->constrained('seccion_noticias')->onDelete('cascade');
            $table->string('titulo');
            $table->string('descripcion');
            $table->text('contenido');
            $table->string('autor_noticia');
            $table->string('imagen');
            $table->string('descripcion_imagen');
            $table->string('autor_imagen');
            $table->date('fecha_publicacion');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        
        Schema::dropIfExists('noticias');
        Schema::dropIfExists('seccion_noticias');
    }
};

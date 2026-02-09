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
        Schema::create('restaurante_etiqueta', function (Blueprint $table) {
            
            // -- Esta tabla se crea porque un restaurante puede tener 
            // -- muchas etiquetas y una etiqueta puede tener muchos 
            // -- restaurantes. -- //
        
        
            $table->id();

            // -- Id restaurante -- //
            $table->unsignedBigInteger('id_restaurante');
            $table->foreign('id_restaurante')->references('id')->on('restaurante')->onDelete('cascade');
            
            // -- Id etiqueta -- //
            $table->unsignedBigInteger('id_etiqueta');
            $table->foreign('id_etiqueta')->references('id')->on('etiqueta')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurante_etiqueta');
    }
};

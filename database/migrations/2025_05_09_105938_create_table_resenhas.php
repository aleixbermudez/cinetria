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
        Schema::create('resenhas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('id_usuario')->required();
            $table->string('valoracion')->required();
            $table->string('opinion_texto');
            $table->string('id_contenido')->required();
            $table->string('tipo_contenido')->required();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenhas');
    }
};

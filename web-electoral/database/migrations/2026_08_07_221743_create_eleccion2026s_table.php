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
        Schema::create('eleccion2026s', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->dateTime('fecha_inicio');
        $table->dateTime('fecha_fin');
        $table->enum('estado', ['activa', 'cerrada'])->default('activa');
        $table->timestamp('fecha_cierre_real')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleccion2026s');
    }
};

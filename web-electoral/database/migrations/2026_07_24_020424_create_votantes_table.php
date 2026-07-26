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
        Schema::create('votantes', function (Blueprint $table) {
            $table->id('id_votante');
            $table->string('dui', 10)->unique();
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->boolean('ha_votado')->default(false);
            $table->dateTime('fecha_voto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votantes');
    }
};

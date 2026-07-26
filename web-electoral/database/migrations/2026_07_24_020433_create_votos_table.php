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
        Schema::create('votos', function (Blueprint $table) {
            $table->id('id_voto');

            $table->foreignId('id_partido')
                  ->constrained(
                      table: 'partidos',
                      column: 'id_partido'
                  )
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->timestamp('fecha_votado')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votos');
    }
};

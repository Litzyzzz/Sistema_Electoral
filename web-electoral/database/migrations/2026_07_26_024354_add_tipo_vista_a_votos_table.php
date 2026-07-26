<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//tabla que usé para actualizar la tabla votos y agregar el campo tipo_vista
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    
    {
        Schema::table('votos', function (Blueprint $table) {
            $table->enum('tipo_vista', ['rostro', 'bandera'])->after('id_partido')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votos', function (Blueprint $table) {
            $table->dropColumn('tipo_vista');
        });
    }
};

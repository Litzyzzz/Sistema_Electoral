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
        if (Schema::hasColumn('votantes', 'dui') && !Schema::hasColumn('votantes', 'codigo_estudiante')) {
            Schema::table('votantes', function (Blueprint $table) {
                $table->renameColumn('dui', 'codigo_estudiante');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('votantes', 'codigo_estudiante') && !Schema::hasColumn('votantes', 'dui')) {
            Schema::table('votantes', function (Blueprint $table) {
                $table->renameColumn('codigo_estudiante', 'dui');
            });
        }
    }
};

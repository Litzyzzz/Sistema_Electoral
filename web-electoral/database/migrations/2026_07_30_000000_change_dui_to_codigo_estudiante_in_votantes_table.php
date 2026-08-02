<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('votantes', 'dui') && !Schema::hasColumn('votantes', 'codigo_estudiante')) {
            DB::statement('ALTER TABLE votantes CHANGE dui codigo_estudiante VARCHAR(20) NOT NULL UNIQUE');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('votantes', 'codigo_estudiante') && !Schema::hasColumn('votantes', 'dui')) {
            DB::statement('ALTER TABLE votantes CHANGE codigo_estudiante dui VARCHAR(20) NOT NULL UNIQUE');
        }
    }
};

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        $this->call([
            VotanteSeeder::class,
        ]);

        $partidos = [
            [
                'nombre_partido' => 'AVDES',
                'bandera' => 'avdes.jpeg',
                'nombre_candidato' => 'XIMENA LETIZIA MORENO',
                'rostro_candidato' => 'ximena.jpeg',
                'descripcion' => 'Alianza por la Vision y Desarrollo',
            ],
            [
                'nombre_partido' => 'MUN',
                'bandera' => 'mun.jpeg',
                'nombre_candidato' => 'ROGER JOSUE HURTADO',
                'rostro_candidato' => 'roger.jpeg',
                'descripcion' => 'Movimiento de Unidad Nacional',
            ],
            [
                'nombre_partido' => 'UPC',
                'bandera' => 'arena.png',
                'nombre_candidato' => 'ALFREDO EZEQUIEL MEDRANO',
                'rostro_candidato' => 'alfredo.jpeg',
                'descripcion' => 'Union para el Cambio',
            ],
        ];

        foreach ($partidos as $partido) {
            DB::table('partidos')->updateOrInsert(
                ['nombre_partido' => $partido['nombre_partido']],
                $partido
            );
        }
    }
}

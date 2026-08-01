<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Votante;

class VotanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $votantes = [
            [
                'codigo_estudiante' => 'EST-001',
                'nombres' => 'Juan Antonio',
                'apellidos' => 'Pérez Molina',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'EST-002',
                'nombres' => 'María Carmen',
                'apellidos' => 'Gómez López',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'EST-003',
                'nombres' => 'Carlos Eduardo',
                'apellidos' => 'Rodríguez Silva',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'EST-004',
                'nombres' => 'Ana Lucía',
                'apellidos' => 'Fernández Martínez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'EST-005',
                'nombres' => 'Roberto Carlos',
                'apellidos' => 'Sánchez Hernández',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS126623',
                'nombres' => 'Gabriela Estafani',
                'apellidos' => 'Vasquez Hidalgo',
                'ha_votado' => false,
            ],
        ];

        foreach ($votantes as $votanteData) {
            Votante::updateOrCreate(
                ['codigo_estudiante' => $votanteData['codigo_estudiante']],
                $votanteData
            );
        }
    }
}

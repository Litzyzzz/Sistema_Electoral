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
                'codigo_estudiante' => 'SMSS016721',
                'nombres' => 'Javier Alejandro',
                'apellidos' => 'Rivas Perla',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS101123',
                'nombres' => 'Andrea Patricia',
                'apellidos' => 'Ramos Hernández',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS127823',
                'nombres' => 'Wesley Levi',
                'apellidos' => 'Vasquez Reyes',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS065723',
                'nombres' => 'Angel Mauricio',
                'apellidos' => 'Hernandez Amaya',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS126623',
                'nombres' => 'Gabriela Estefani',
                'apellidos' => 'Vasquez Hidalgo',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS112623',
                'nombres' => 'Cristian Ernesto',
                'apellidos' => 'Rosa Escobar',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS092022',
                'nombres' => 'Diego Alexander',
                'apellidos' => 'Reyes Funes',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS126723',
                'nombres' => 'Santiago José',
                'apellidos' => 'Quito Fuentes',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS188122',
                'nombres' => 'Nelcy Nohemy',
                'apellidos' => 'Avalos',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS014723',
                'nombres' => 'Litzy Cecibel',
                'apellidos' => 'Argueta Pérez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS010623',
                'nombres' => 'Noé Isaí',
                'apellidos' => 'Hernández Rivas',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS151623',
                'nombres' => 'Blanca Yulissa',
                'apellidos' => 'Argueta Martínez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS156223',
                'nombres' => 'Edith Saraí',
                'apellidos' => 'Claros Sorto',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS204726',
                'nombres' => 'Rafael Alejandro',
                'apellidos' => 'Gomez Morejón',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS042123',
                'nombres' => 'Angel Ezequiel',
                'apellidos' => 'Sorto Gonzalez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS058623',
                'nombres' => 'Ximena Letizia',
                'apellidos' => 'Moreno Díaz',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS098123',
                'nombres' => 'Roger Josue',
                'apellidos' => 'Hurtado Rivera',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS114223',
                'nombres' => 'Samuel Alexander',
                'apellidos' => 'Vargas Rivera',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS098223',
                'nombres' => 'Jorge Alexis',
                'apellidos' => 'Salgado Amaya',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS074823',
                'nombres' => 'Carlos Arnoldo',
                'apellidos' => 'Romero Espinal',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS063523',
                'nombres' => 'Blanca Leticia',
                'apellidos' => 'Argueta Portillo',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS093423',
                'nombres' => 'Eduardo Antonio',
                'apellidos' => 'Fuentes Melara',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS025923',
                'nombres' => 'Cristian Noé',
                'apellidos' => 'Pérez Vásquez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS059023',
                'nombres' => 'Mauricio Alfredo',
                'apellidos' => 'Carranza Velasquez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'USSS037423',
                'nombres' => 'Gerson Daniel',
                'apellidos' => 'Guerrero Castillo',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS031323',
                'nombres' => 'Scarleth Yadira',
                'apellidos' => 'Portillo Estrada',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS111223',
                'nombres' => 'Fabiola Alejandra',
                'apellidos' => 'Benítez Osorto',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS063723',
                'nombres' => 'Ivette Azucena',
                'apellidos' => 'Mendiola Requeno',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS150823',
                'nombres' => 'Javier Alexander',
                'apellidos' => 'Vargas Díaz',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS141223',
                'nombres' => 'Emerson Aldahir',
                'apellidos' => 'Portillo Segovia',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS012223',
                'nombres' => 'José Luis',
                'apellidos' => 'Escobar Cáceres',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS011422',
                'nombres' => 'Katia Marilin',
                'apellidos' => 'Santos Avelar',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS003223',
                'nombres' => 'Camila Yaneli',
                'apellidos' => 'Romero Calderón',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS205226',
                'nombres' => 'Ángel Daniel',
                'apellidos' => 'Romero Argueta',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS169725',
                'nombres' => 'Erick Fernando',
                'apellidos' => 'Trejo Parada',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS180923',
                'nombres' => 'Lilian Amaraly',
                'apellidos' => 'Perla Arias',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS200026',
                'nombres' => 'Uriel Alexander',
                'apellidos' => 'Guevara Argueta',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => '2617',
                'nombres' => 'Paola Cristina',
                'apellidos' => 'Ferrufino Flores',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS125223',
                'nombres' => 'Flor Guadalupe',
                'apellidos' => 'Villatoro Vasquez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS025223',
                'nombres' => 'Alfredo Ezequiel',
                'apellidos' => 'Medrano Martínez',
                'ha_votado' => false,
            ],
            [
                'codigo_estudiante' => 'SMSS141823',
                'nombres' => 'William Alfredo',
                'apellidos' => 'Irula González',
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

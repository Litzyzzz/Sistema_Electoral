<?php

namespace Tests\Feature;

use App\Models\Votante;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdentificacionTest extends TestCase
{
    use RefreshDatabase;

    public function test_identificacion_accepts_codigo_estudiante_and_sets_session(): void
    {
        Votante::create([
            'codigo_estudiante' => 'EST-001',
            'nombres' => 'Carlos',
            'apellidos' => 'Mora',
            'ha_votado' => false,
        ]);

        $response = $this->post(route('verificar.dui.post'), [
            'codigo_estudiante' => 'EST-001',
            'nombres' => 'Carlos',
            'apellidos' => 'Mora',
        ]);

        $response->assertRedirect(route('votacion'));
        $response->assertSessionHas('id_votante');
    }
}

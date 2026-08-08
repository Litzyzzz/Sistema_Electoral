<?php

namespace App\Console\Commands;

use App\Models\Eleccion2026;
use Illuminate\Console\Command;

class IniciarElecciones2026 extends Command
{
    protected $signature = 'elecciones:iniciar';

    protected $description = 'Inicia las elecciones 2026';

    public function handle()
    {
        $eleccion = Eleccion2026::first();

        if (!$eleccion) {
            $this->error('No existe una elección configurada.');

            return Command::FAILURE;
        }

        if ($eleccion->estado === 'activa') {
            $this->warn('Las elecciones ya están activas.');

            return Command::SUCCESS;
        }

        $eleccion->update([
            'estado' => 'activa',
            'fecha_inicio' => now(),
            'fecha_cierre_real' => null,
        ]);

        $this->info('Las elecciones han sido iniciadas correctamente.');

        return Command::SUCCESS;
    }
}
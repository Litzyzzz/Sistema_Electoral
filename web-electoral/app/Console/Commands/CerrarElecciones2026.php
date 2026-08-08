<?php

namespace App\Console\Commands;

use App\Models\Eleccion2026;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;


class CerrarElecciones2026 extends Command
{
    protected $signature = 'elecciones:cerrar';

    protected $description = 'Cierra automáticamente las elecciones cuyo tiempo ha terminado';

    public function handle()
    {
        $elecciones = Eleccion2026::where('estado', 'activa')
            ->where('fecha_fin', '<=', now())
            ->get();

        foreach ($elecciones as $eleccion) {
            $eleccion->update([
                'estado' => 'cerrada',
                'fecha_cierre_real' => now(),
            ]);

            $this->info(
                "Elección cerrada: {$eleccion->nombre}"
            );
        }

        return Command::SUCCESS;
    }
}

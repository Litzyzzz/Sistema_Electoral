<?php

namespace App\Http\Controllers;

use App\Models\Eleccion2026;
use Illuminate\Http\Request;

class EleccionController extends Controller
{
    public function iniciar(Eleccion2026 $eleccion)
    {
        $eleccion->update([
            'estado' => 'activa',
            'fecha_inicio' => now(),
            'fecha_cierre_real' => null,
        ]);

        return back()->with(
            'success',
            'Las elecciones han sido iniciadas correctamente'
        );
    }
    public function cerrar(Eleccion2026 $eleccion)
        {
            $eleccion->update([
                'estado' => 'cerrada',
                'fecha_cierre_real' => now(),
            ]);

            return back()->with(
                'success',
                'Las elecciones han sido cerradas correctamente'
            );
    }


    public function cerrarManual()
    {
        $eleccion = Eleccion2026::where('estado', 'activa')->first();

        if (!$eleccion) {
            return redirect()
                ->back()
                ->with('error', 'No hay elecciones activas.');
        }

        $eleccion->update([
            'estado' => 'cerrada',
            'fecha_cierre_real' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Las votaciones fueron cerradas correctamente.');
    }

    
}

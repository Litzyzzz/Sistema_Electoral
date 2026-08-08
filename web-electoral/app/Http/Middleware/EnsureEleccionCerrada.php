<?php

namespace App\Http\Middleware;

use App\Models\Eleccion2026;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEleccionCerrada
{
    public function handle(Request $request, Closure $next): Response
    {
        $eleccion = Eleccion2026::first();

        // Si no existe la elección o todavía no está cerrada
        if (!$eleccion || $eleccion->estado !== 'cerrada') {
            return response()->view('resultados.no-disponible', [
                'eleccion' => $eleccion
            ]);
        }

        return $next($request);
    }
}
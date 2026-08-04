<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureResultadosAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $isAuthenticated = (bool) $request->session()->get('resultados_auth', false);
        $hasVotanteId = $request->session()->has('resultados_votante_id');

        if (!$isAuthenticated && !$hasVotanteId) {
            return redirect()
                ->route('resultados.login')
                ->with('error', 'Debe autenticarse para consultar los resultados.');
        }

        if (!$isAuthenticated && $hasVotanteId) {
            $request->session()->put('resultados_auth', true);
        }

        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}

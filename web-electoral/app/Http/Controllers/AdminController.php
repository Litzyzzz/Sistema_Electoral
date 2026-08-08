<?php

namespace App\Http\Controllers;

use App\Models\Votante;
use App\Models\Eleccion2026;
use App\Models\Voto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{

    public function showLogin(): View
    {
        return view('layouts.admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $codigoValue = trim((string) $request->input('codigo_estudiante'));
        $nombresValue = preg_replace('/\s+/', ' ',trim((string) $request->input('nombres')) );
        $apellidosValue = preg_replace('/\s+/',' ',trim((string) $request->input('apellidos')));
        $request->merge([
            'codigo_estudiante' => $codigoValue,
            'nombres' => $nombresValue,
            'apellidos' => $apellidosValue,
        ]);
        $request->validate([
            'codigo_estudiante' => [
                'required',
                'string',
                'max:20'
            ],
            'nombres' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)+$/u'
            ],
            'apellidos' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)+$/u'
            ],

        ], [
            'nombres.regex' =>
                'Ingrese nombres completos (mínimo dos palabras) y con la primera letra de cada palabra en mayúscula.',
            'apellidos.regex' =>
                'Ingrese apellidos completos (mínimo dos palabras) y con la primera letra de cada palabra en mayúscula.',
        ]);

        $codigo = $request->input('codigo_estudiante');
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');

        $votante = Votante::query()
            ->where('codigo_estudiante', $codigo)
            ->where('puede_ver_resultados', true)
            ->first();

        if ($votante) {
            $nombresInputComparable = mb_strtolower($nombres,'UTF-8');
            $apellidosInputComparable = mb_strtolower($apellidos,'UTF-8' );
            $nombresStoredComparable = mb_strtolower(preg_replace('/\s+/', ' ', trim((string) $votante->nombres)), 'UTF-8');
            $apellidosStoredComparable = mb_strtolower(preg_replace('/\s+/',' ',trim((string) $votante->apellidos)),'UTF-8');
                
            if (
                $nombresInputComparable !== $nombresStoredComparable ||$apellidosInputComparable !== $apellidosStoredComparable){ 
                $votante = null;
            }
        }

        if (!$votante) {
            return back()
                ->withInput()
                ->with('error', 'Credenciales incorrectas');
        }
        $request->session()->regenerate();
        $request->session()->put('admin_auth',true);
        $request->session()->put('admin_votante_id',$votante->id_votante);
        return redirect()->route('admin.control');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([ 'admin_auth','admin_votante_id']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
    public function control(): View
    {
    $eleccion = Eleccion2026::first();

        $totalVotantes = Votante::count();

        $totalVotos = Voto::count();

        $participacion = $totalVotantes > 0
            ? round(($totalVotos / $totalVotantes) * 100, 2)
            : 0;

        return view('layouts.admin.control', [
            'eleccion' => $eleccion,
            'totalVotantes' => $totalVotantes,
            'totalVotos' => $totalVotos,
            'participacion' => $participacion,

            'authVotante' => Votante::find(
                session('admin_votante_id')
                ),
        ]);
    }
}
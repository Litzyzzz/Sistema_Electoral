<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Votante;
use App\Models\Voto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ResultadosController extends Controller
{
    public function showLogin(): View
    {
        return view('resultados.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $codigoValue = trim((string) $request->input('codigo_estudiante'));
        $nombresValue = preg_replace('/\s+/', ' ', trim((string) $request->input('nombres')));
        $apellidosValue = preg_replace('/\s+/', ' ', trim((string) $request->input('apellidos')));

        $request->merge([
            'codigo_estudiante' => $codigoValue,
            'nombres' => $nombresValue,
            'apellidos' => $apellidosValue,
        ]);

        $request->validate([
            'codigo_estudiante' => ['required', 'string', 'max:20'],
            'nombres' => ['required', 'string', 'max:50', 'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)+$/u'],
            'apellidos' => ['required', 'string', 'max:50', 'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)+$/u'],
        ], [
            'nombres.regex' => 'Ingrese nombres completos (mínimo dos palabras) y con la primera letra de cada palabra en mayúscula.',
            'apellidos.regex' => 'Ingrese apellidos completos (mínimo dos palabras) y con la primera letra de cada palabra en mayúscula.',
        ]);

        $codigo = $request->input('codigo_estudiante');
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');

        $votante = Votante::query()
            ->where('codigo_estudiante', $codigo)
            ->where('puede_ver_resultados', true)
            ->first();

        if ($votante) {
            $nombresInputComparable = mb_strtolower($nombres, 'UTF-8');
            $apellidosInputComparable = mb_strtolower($apellidos, 'UTF-8');
            $nombresStoredComparable = mb_strtolower(preg_replace('/\s+/', ' ', trim((string) $votante->nombres)), 'UTF-8');
            $apellidosStoredComparable = mb_strtolower(preg_replace('/\s+/', ' ', trim((string) $votante->apellidos)), 'UTF-8');

            if ($nombresInputComparable !== $nombresStoredComparable || $apellidosInputComparable !== $apellidosStoredComparable) {
                $votante = null;
            }
        }

        if (!$votante) {
            return back()
                ->withInput()
                ->with('error', 'Credenciales incorrectas');
        }

        $request->session()->regenerate();
        $request->session()->put('resultados_auth', true);
        $request->session()->put('resultados_votante_id', $votante->id_votante);

        return redirect()->route('resultados.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['resultados_auth', 'resultados_votante_id']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('resultados.login');
    }

    public function dashboard(): View
    {
        $data = $this->buildResultadosData();

        return view('resultados.dashboard', $data);
    }

    public function rostro(): View
    {
        $data = $this->buildResultadosData('rostro');

        return view('resultados.rostro', $data);
    }

    public function bandera(): View
    {
        $data = $this->buildResultadosData('bandera');

        return view('resultados.bandera', $data);
    }

    private function buildResultadosData(?string $tipoVista = null): array
    {
        $authVotante = Votante::query()->find(session('resultados_votante_id'));

        $votosQuery = Voto::query();
        if ($tipoVista !== null) {
            $votosQuery->where('tipo_vista', $tipoVista);
        }

        $totalVotos = (clone $votosQuery)->count();
        $totalVotantes = Votante::query()->count();
        $totalCandidatos = Partido::query()->count();

        $participacion = $totalVotantes > 0
            ? round(($totalVotos / $totalVotantes) * 100, 2)
            : 0;

        $ranking = Partido::query()
            ->leftJoin('votos', function ($join) use ($tipoVista) {
                $join->on('partidos.id_partido', '=', 'votos.id_partido');

                if ($tipoVista !== null) {
                    $join->where('votos.tipo_vista', '=', $tipoVista);
                }
            })
            ->select(
                'partidos.id_partido',
                'partidos.nombre_partido',
                'partidos.bandera',
                'partidos.nombre_candidato',
                'partidos.rostro_candidato',
                'partidos.descripcion',
                DB::raw('COUNT(votos.id_voto) AS total_votos')
            )
            ->groupBy(
                'partidos.id_partido',
                'partidos.nombre_partido',
                'partidos.bandera',
                'partidos.nombre_candidato',
                'partidos.rostro_candidato',
                'partidos.descripcion'
            )
            ->orderByDesc('total_votos')
            ->orderBy('partidos.nombre_candidato')
            ->get()
            ->map(function ($item) use ($totalVotos) {
                $item->porcentaje = $totalVotos > 0
                    ? round(($item->total_votos / $totalVotos) * 100, 2)
                    : 0;

                return $item;
            });

        $ganador = $ranking->first();

        return [
            'authVotante' => $authVotante,
            'totalVotos' => $totalVotos,
            'totalVotantes' => $totalVotantes,
            'totalCandidatos' => $totalCandidatos,
            'participacion' => $participacion,
            'ranking' => $ranking,
            'ganador' => $ganador,
            'chartLabels' => $ranking->pluck('nombre_candidato')->values(),
            'chartData' => $ranking->pluck('total_votos')->values(),
            'chartPercentages' => $ranking->pluck('porcentaje')->values(),
        ];
    }
}

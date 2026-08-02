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
        $request->validate([
            'codigo_estudiante' => ['required', 'string', 'max:20'],
            'nombres' => ['required', 'string', 'max:50'],
            'apellidos' => ['required', 'string', 'max:50'],
        ]);

        $codigo = trim($request->input('codigo_estudiante'));
        $nombres = trim($request->input('nombres'));
        $apellidos = trim($request->input('apellidos'));

        $votante = Votante::query()
            ->where('codigo_estudiante', $codigo)
            ->where('nombres', $nombres)
            ->where('apellidos', $apellidos)
            ->where('puede_ver_resultados', true)
            ->first();

        if (!$votante) {
            return back()
                ->withInput()
                ->with('error', 'Credenciales incorrectas');
        }

        $request->session()->put('resultados_auth', true);
        $request->session()->put('resultados_votante_id', $votante->id_votante);
        $request->session()->regenerate();

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
        $data = $this->buildResultadosData();

        return view('resultados.rostro', $data);
    }

    public function bandera(): View
    {
        $data = $this->buildResultadosData();

        return view('resultados.bandera', $data);
    }

    private function buildResultadosData(): array
    {
        $authVotante = Votante::query()->find(session('resultados_votante_id'));

        $totalVotos = Voto::query()->count();
        $totalVotantes = Votante::query()->count();
        $totalCandidatos = Partido::query()->count();

        $participacion = $totalVotantes > 0
            ? round(($totalVotos / $totalVotantes) * 100, 2)
            : 0;

        $ranking = Partido::query()
            ->leftJoin('votos', 'partidos.id_partido', '=', 'votos.id_partido')
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

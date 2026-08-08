<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Votante;
use App\Models\Voto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Eleccion2026;

class ResultadosController extends Controller
{

    public function dashboard(): View
    {
        $eleccion = Eleccion2026::first();

        // Si las elecciones todavía están activas
        if (!$eleccion || $eleccion->estado !== 'cerrada') {
            return view('resultados.no-disponible',compact('eleccion') );
            
        }

        // Si ya están cerradas, mostrar resultados
        $data = $this->buildResultadosData();

        $data['eleccion'] = $eleccion;

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

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Votante;
use App\Models\Partido;
use App\Models\Voto;
use App\Models\Eleccion2026;

class VotacionController extends Controller
{
    public function inicio()
    {
        return view('inicio');
    }

    public function identificacion()
    {
        $eleccion = Eleccion2026::first();

        // Si las elecciones ya terminaron
        if (!$eleccion || $eleccion->estado === 'cerrada') {
            return view('layouts.no-pasar', compact('eleccion'));
        }

        // Si las elecciones siguen activas
        return view('identificacion');
    }

    public function verificarDui(Request $request)
    {
        $codigoValue = $request->input('codigo_estudiante', $request->input('dui'));
        $nombresValue = preg_replace('/\s+/', ' ', trim((string) $request->input('nombres')));
        $apellidosValue = preg_replace('/\s+/', ' ', trim((string) $request->input('apellidos')));

        $request->merge([
            'codigo_estudiante' => trim((string) $codigoValue),
            'nombres' => $nombresValue,
            'apellidos' => $apellidosValue,
        ]);

        $request->validate([
            'codigo_estudiante' => ['required', 'string', 'max:20'],
            'nombres' => ['required', 'string', 'max:50', 'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)+$/u'],
            'apellidos' => ['required', 'string', 'max:50', 'regex:/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+(?:\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)+$/u']
        ], [
            'codigo_estudiante.required' => 'El campo código de estudiante es obligatorio',
            'codigo_estudiante.string' => 'El código de estudiante debe ser texto',
            'codigo_estudiante.max' => 'El código de estudiante no puede tener más de 20 caracteres',
            'nombres.required' => 'El campo nombres es obligatorio',
            'nombres.max' => 'Los nombres no pueden tener más de 50 caracteres',
            'nombres.regex' => 'Ingrese nombres completos (mínimo dos palabras) y con la primera letra de cada palabra en mayúscula.',
            'apellidos.required' => 'El campo apellidos es obligatorio',
            'apellidos.max' => 'Los apellidos no pueden tener más de 50 caracteres',
            'apellidos.regex' => 'Ingrese apellidos completos (mínimo dos palabras) y con la primera letra de cada palabra en mayúscula.',
        ]);

        $codigo = $request->input('codigo_estudiante');
        $nombres = $request->input('nombres');
        $apellidos = $request->input('apellidos');

        $votante = Votante::query()
            ->where('codigo_estudiante', $codigo)
            ->first();

        if ($votante && $votante->ha_votado) {
            return back()->with('error', 'Esta persona ya emitió su voto.');
        }

        if ($votante) {
            $votante->nombres = $nombres ?: $votante->nombres;
            $votante->apellidos = $apellidos ?: $votante->apellidos;
            $votante->save();
        } else {
            $votante = Votante::create([
                'codigo_estudiante' => $codigo,
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'ha_votado' => false,
                'puede_ver_resultados' => false,
            ]);
        }

        session(['id_votante' => $votante->id_votante]);
        session()->forget('voto_realizado');

        return redirect()->route('votacion')->with('success', 'Identidad verificada.');
    }

    public function votacion(Request $request)
    {
        // verifica que hay un votante en sesión
        if (!session()->has('id_votante')) {
            return redirect()->route('identificacion')->with('error', 'Debe identificarse primero.');
        }

        // verifica que este votante no haya votado ya
        $votante = Votante::find(session('id_votante'));
        if ($votante && $votante->ha_votado) {
            return redirect()->route('inicio')->with('error', 'Esta persona ya emitió su voto.');
        }

        $partidos = Partido::all();
        $vista = $request->get('vista', 'rostro');
        
        return view('votacion', compact('partidos', 'vista'));
    }

    public function confirmacion($id, Request $request)
        {
        // verifica que hay un votante en sesión
        if (!session()->has('id_votante')) {
            return redirect()->route('identificacion')->with('error', 'Debe identificarse primero.');
        }

        // verifica que este votante no haya votado ya
        $votante = Votante::find(session('id_votante'));
        if ($votante && $votante->ha_votado) {
            return redirect()->route('inicio')->with('error', 'Esta persona ya emitió su voto.');
        }

        $candidato = Partido::find($id);
        $vista = $request->get('vista', 'rostro'); 

        if (!$candidato) {
            return redirect()->route('votacion')->with('error', 'El candidato seleccionado no existe.');
        }
        return view('confirmacion', compact('candidato', 'vista'));
        }
    public function guardarVoto(Request $request)
    {
        // este verifica que el votante este "autenticado/puesto los datos"
        if (!session()->has('id_votante')) {
            return redirect()->route('identificacion')->with('error', 'Debe identificarse primero.');

        }
        // este verifica que las elecciones esten activas
        $eleccion = Eleccion2026::first();
        if (
            !$eleccion ||
            $eleccion->estado !== 'activa' ||
            now()->greaterThanOrEqualTo($eleccion->fecha_fin)
        ) {
            return redirect()
                ->route('inicio')
                ->with('error', 'Las elecciones han finalizado');
        }

        // aqui verifica que el votante no haya votado ya
        $votante = Votante::find(session('id_votante'));
        if ($votante && $votante->ha_votado) {
            return redirect()->route('inicio')->with('error', 'Esta persona ya emitió su voto.');
        }

        $request->validate([
            'id_partido' => 'required|exists:partidos,id_partido',
            'tipo_vista' => 'required|in:rostro,bandera'
        ]);

        try {
            //  transacción para asegurar integridad
            DB::beginTransaction();

            // registra el voto
            Voto::create([
                'id_partido' => $request->id_partido,
                'tipo_vista' => $request->tipo_vista,
                'fecha_votado' => now()
            ]);

            // marca al votante como que ya votó
            $votante->ha_votado = true;
            $votante->fecha_voto = now();
            $votante->save();

            DB::commit();

            // Marca que el votante acaba de finalizar su votación
            session()->put('voto_realizado', true);

            // Ya no necesitamos el ID del votante
            session()->forget('id_votante');

            return redirect()->route('finalizacion')
                ->with('success', '¡Tu voto ha sido registrado exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al registrar el voto. Por favor, intenta nuevamente.');
        }
    }

    public function finalizacion()
    {
        return view('finalizado');
    }

    public function cerrarFlujo(Request $request)
    {
        $request->session()->forget(['id_votante', 'voto_realizado']);

        return response()->json(['ok' => true]);
    }

}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Votante;
use App\Models\Partido;
use App\Models\Voto;

class VotacionController extends Controller
{
    public function inicio()
    {
        return view('inicio');
    }

    public function identificacion()
    {
        return view('identificacion');
    }

    public function verificarDui(Request $request)
    {
    // validaciones de los campos
        $request->validate([
            'dui' => 'required|regex:/^\d{8}-\d$/',
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50'
        ],
    //otras validaciones    
        [
        'dui.required' => 'El campo DUI es obligatorio',
        'dui.regex' => 'El DUI debe tener el formato 00000000-0 (8 dígitos, guión, 1 dígito)',
        'nombres.required' => 'El campo nombres es obligatorio',
        'nombres.max' => 'Los nombres no pueden tener más de 50 caracteres',
        'apellidos.required' => 'El campo apellidos es obligatorio',
        'apellidos.max' => 'Los apellidos no pueden tener más de 50 caracteres',
    ]);
    

        // verifica si la persona ya votó
        $votante = Votante::where('dui', $request->dui)->first();

        if ($votante && $votante->ha_votado) {
            return back()->with('error', 'Esta persona ya emitió su voto.');
        }

        // si no existe, crea nuevo votante
        if (!$votante) {
            $votante = Votante::create([
                'dui' => $request->dui,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'ha_votado' => false
            ]);
        }

        // la guarda en sesión
        session(['id_votante' => $votante->id_votante]);

        // elimina cualquier voto previo en sesión
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

            // limpia la sesion
            session()->forget(['id_votante', 'voto_realizado']);

            return redirect()->route('finalizacion')->with('success', '¡Tu voto ha sido registrado exitosamente!');

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
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['ok' => true]);
    }

}

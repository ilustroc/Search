<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Importante para la estabilidad
use Carbon\Carbon;

class SearchController extends Controller
{
    /**
     * API para validar WhatsApp en segundo plano
     */
    public function validarWhatsapp($telefono)
    {
        return Cache::remember("ws_val_{$telefono}", 86400, function () use ($telefono) {
            // --- Lógica propia de validación ---
            // Aquí puedes poner una lista negra o conectar tu propia base de datos de inactivos
            $inactivos = ['932513281']; 

            $exists = !in_array($telefono, $inactivos) && (strlen($telefono) === 9);

            return response()->json([
                'exists' => $exists,
                'phone'  => $telefono
            ]);
        });
    }

    /**
     * Realiza la búsqueda y muestra la vista de resultados
     */
    public function buscar(Request $request)
    {
        $dni = $request->query('documento') ?? $request->input('documento');

        if (!$dni && $request->isMethod('get')) {
            return redirect('/');
        }

        $request->validate([
            'documento' => 'required|numeric|digits:8',
        ], [
            'documento.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'documento.required' => 'Debes ingresar un número de documento.',
        ]);

        if ($request->isMethod('post')) {
            return redirect()->route('buscar', ['documento' => $dni]);
        }

        // Optimizamos la carga con caché de 30 minutos para evitar caídas del servidor
        $cliente = Cache::remember("perfil_dni_{$dni}", 1800, function () use ($dni) {
            return Persona::with([
                'direcciones', 'telefonos', 'autos', 'familiares', 'correos', 'propiedades', 'situaciones'
            ])->find($dni);
        });

        if (!$cliente) {
            return back()->withErrors(['documento' => "DNI $dni no encontrado en nuestra base de datos."]);
        }

        $situacionOriginal = $cliente->situaciones->first();
        $situacionData = null;

        if ($situacionOriginal) {
            $detalles = \App\Models\SituacionDetalle::where('documento', $dni)->get();
            
            $n   = $situacionOriginal->calificacion_normal ?? 0;
            $cpp = $situacionOriginal->calificacion_cpp ?? 0;
            $d   = $situacionOriginal->calificacion_deficiente ?? 0;
            $du  = $situacionOriginal->calificacion_dudoso ?? 0;
            $p   = $situacionOriginal->calificacion_perdida ?? 0;
            
            $total = ($n + $cpp + $d + $du + $p) ?: 1;

            $situacionData = (object)[
                'fecha_reporte' => $detalles->first()->fecha_reporte_sbs ?? '---',
                'calificacion_normal' => $n,
                'calificacion_cpp' => $cpp,
                'calificacion_deficiente' => $d,
                'calificacion_dudoso' => $du,
                'calificacion_perdida' => $p,
                'porcentaje_normal' => ($n / $total) * 100,
                'porcentaje_potencial' => ($cpp / $total) * 100,
                'porcentaje_deficiente' => ($d / $total) * 100,
                'porcentaje_dudoso' => ($du / $total) * 100,
                'porcentaje_perdida' => ($p / $total) * 100,
                'detalles' => $detalles 
            ];
        }

        return view('resultado', [
            'cliente'    => $cliente,
            'direccion'  => $cliente->direcciones->first(),
            'telefonos'  => $cliente->telefonos,
            'autos'      => $cliente->autos,
            'familiares' => $cliente->familiares,
            'correos'    => $cliente->correos,
            'sunarp'     => $cliente->propiedades,
            'situacion'  => $situacionData,
            'edad'       => $cliente->nacimiento ? Carbon::parse($cliente->nacimiento)->age : '---'
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{
    /**
     * Recibe el POST del formulario inicial
     */
    public function procesarFormulario(Request $request)
    {
        $request->validate([
            'documento' => 'required|numeric',
            'tipo' => 'nullable|in:DNI,RUC' // Ahora el tipo puede ser opcional
        ]);

        return redirect()->route('buscar.directo', [
            'documento' => $request->documento,
            'tipo' => $request->tipo ?? 'DNI' // Por defecto DNI si se usa el buscador del header
        ]);
    }

    /**
     * Realiza la búsqueda y muestra la vista de resultados
     */
    public function buscar(Request $request, $documento)
    {
        $cliente = Persona::with([
            'direcciones', 'telefonos', 'autos', 'familiares', 'correos', 'propiedades', 'situaciones'
        ])->find($documento);

        if (!$cliente) {
            return view('no_encontrado', compact('documento'));
        }

        $situacionOriginal = $cliente->situaciones->first();
        $situacionData = null;

        if ($situacionOriginal) {
            // --- LA CONSULTA DE DETALLES VA AQUÍ AFUERA ---
            $detalles = \App\Models\SituacionDetalle::where('documento', $documento)
                ->where('cod_sbs', $situacionOriginal->cod_sbs)
                ->get();

            $n   = $situacionOriginal->calificacion_normal ?? 0;
            $cpp = $situacionOriginal->calificacion_cpp ?? 0;
            $d   = $situacionOriginal->calificacion_deficiente ?? 0;
            $du  = $situacionOriginal->calificacion_dudoso ?? 0;
            $p   = $situacionOriginal->calificacion_perdida ?? 0;
            
            $total = ($n + $cpp + $d + $du + $p) ?: 1;

            // Ahora creamos el objeto para la vista
            $situacionData = (object)[
                'fecha_reporte' => $detalles->max('fecha_reporte_sbs') ?? '---',
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
                'detalles' => $detalles // Aquí pasamos los detalles que consultamos arriba
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
            'edad'       => $cliente->nacimiento ? \Carbon\Carbon::parse($cliente->nacimiento)->age : '---'
        ]);
    }
}
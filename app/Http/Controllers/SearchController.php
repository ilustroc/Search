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
        // Validamos que llegue el documento
        $request->validate([
            'documento' => 'required|numeric',
            'tipo' => 'required|in:DNI,RUC'
        ]);

        // Redirigimos a la URL limpia /buscar/12345678?tipo=DNI
        return redirect()->route('buscar.directo', [
            'documento' => $request->documento,
            'tipo' => $request->tipo
        ]);
    }

    /**
     * Realiza la búsqueda y muestra la vista de resultados
     */
    public function buscar(Request $request, $documento)
    {
        // Eager loading para evitar el error de la columna sbs_resumen.cod_sbs
        $cliente = Persona::with([
            'direcciones', 
            'telefonos', 
            'autos', 
            'familiares', 
            'correos', 
            'propiedades', 
            'situaciones' // Quitamos .detalles de aquí para cargarlo manualmente si falla
        ])->find($documento);

        if (!$cliente) {
            return view('no_encontrado', compact('documento'));
        }

        $situacion = $cliente->situaciones->first();
        $situacionData = null;

        if ($situacion) {
            // Carga manual de detalles para asegurar que no rompa por el join de cod_sbs
            $detalles = \App\Models\SituacionDetalle::where('documento', $documento)
                        ->where('cod_sbs', $situacion->cod_sbs)
                        ->get();

            $total = ($situacion->calificacion_normal + $situacion->calificacion_cpp + 
                    $situacion->calificacion_deficiente + $situacion->calificacion_dudoso + 
                    $situacion->calificacion_perdida) ?: 1;

            $situacionData = (object)[
                'fecha_reporte' => $situacion->fecha_reporte,
                'porcentaje_normal' => ($situacion->calificacion_normal / $total) * 100,
                'porcentaje_potencial' => ($situacion->calificacion_cpp / $total) * 100,
                'porcentaje_deficiente' => ($situacion->calificacion_deficiente / $total) * 100,
                'porcentaje_dudoso' => ($situacion->calificacion_dudoso / $total) * 100,
                'porcentaje_perdida' => ($situacion->calificacion_perdida / $total) * 100,
                'detalles' => $detalles
            ];
        }

        return view('resultado', [
            'cliente' => $cliente,
            'direccion' => $cliente->direcciones->first(),
            'telefonos' => $cliente->telefonos,
            'autos' => $cliente->autos,
            'familiares' => $cliente->familiares,
            'correos' => $cliente->correos,
            'sunarp' => $cliente->propiedades,
            'situacion' => $situacionData,
            'edad' => $cliente->nacimiento ? Carbon::parse($cliente->nacimiento)->age : '---'
        ]);
    }
}
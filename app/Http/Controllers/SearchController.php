<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function buscar(Request $request, $documento)
    {
        // 1. Cargamos todo en una sola consulta eficiente (Equivalente a tus Services)
        $cliente = Persona::with([
            'direcciones',
            'telefonos' => fn($q) => $q->orderBy('fecha_activacion', 'desc'),
            'autos',
            'familiares',
            'correos',
            'propiedades',
            'situaciones.detalles'
        ])->where('documento', $documento)->first();

        if (!$cliente) {
            return view('no_encontrado', compact('documento'));
        }

        // 2. Procesamos la Situación Financiera (Lógica de tu situacion_service.py)
        $situacionData = null;
        $situacionOriginal = $cliente->situaciones->first();

        if ($situacionOriginal) {
            $n   = $situacionOriginal->calificacion_normal ?? 0;
            $cpp = $situacionOriginal->calificacion_cpp ?? 0;
            $d   = $situacionOriginal->calificacion_deficiente ?? 0;
            $du  = $situacionOriginal->calificacion_dudoso ?? 0;
            $p   = $situacionOriginal->calificacion_perdida ?? 0;
            
            $total = ($n + $cpp + $d + $du + $p) ?: 1;

            $situacionData = [
                'fecha_reporte' => $situacionOriginal->fecha_reporte,
                'porcentaje_normal' => number_format(($n / $total) * 100, 2),
                'porcentaje_potencial' => number_format(($cpp / $total) * 100, 2),
                'porcentaje_deficiente' => number_format(($d / $total) * 100, 2),
                'porcentaje_dudoso' => number_format(($du / $total) * 100, 2),
                'porcentaje_perdida' => number_format(($p / $total) * 100, 2),
                'detalles' => $situacionOriginal->detalles
            ];
        }

        // 3. Retornamos la vista con los datos ya procesados
        return view('resultado', [
            'cliente'    => $cliente,
            'edad'       => $cliente->edad, // Usamos el accessor definido en el modelo
            'direccion'  => $cliente->direcciones->first(),
            'telefonos'  => $cliente->telefonos,
            'autos'      => $cliente->autos,
            'familiares' => $cliente->familiares,
            'correos'    => $cliente->correos,
            'sunarp'     => $cliente->propiedades,
            'situacion'  => $situacionData,
        ]);
    }
}
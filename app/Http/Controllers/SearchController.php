<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{
    /**
     * Realiza la búsqueda y muestra la vista de resultados
     */
    public function buscar(Request $request, $documento = null)
    {
        // 1. Obtener el DNI ya sea del formulario (POST) o de la URL (GET)
        $dni = $request->documento ?? $documento;

        // 2. Si no hay DNI y es una entrada directa por GET, mandamos al inicio
        if (!$dni && $request->isMethod('get')) {
            return redirect('/');
        }

        // 3. Validación: Si el DNI no tiene 8 dígitos o no es numérico, rebota con alerta
        if (!$dni || strlen($dni) !== 8 || !is_numeric($dni)) {
            return back()->withErrors(['documento' => 'Número de DNI inválido. Debe tener 8 dígitos.']);
        }

        // 4. Consulta a la base de datos
        $cliente = Persona::with([
            'direcciones', 'telefonos', 'autos', 'familiares', 'correos', 'propiedades', 'situaciones'
        ])->find($dni);

        // 5. Si el DNI no existe: Rebota a la pantalla actual con la alerta roja
        if (!$cliente) {
            return back()->withErrors(['documento' => "DNI $dni no encontrado."]);
        }

        // 6. REDIRECCIÓN PARA URL LIMPIA: Si el DNI existe y venimos de un POST (formulario),
        // redirigimos a la ruta GET para que la URL sea /buscar/{dni}
        if ($request->isMethod('post')) {
            return redirect()->route('buscar.directo', ['documento' => $dni]);
        }

        // 7. Lógica de situación financiera (SBS)
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

        // 8. Retorno de la vista de resultados
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
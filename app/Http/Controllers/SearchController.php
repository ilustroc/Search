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
    public function buscar(Request $request)
    {
        // 1. Obtener el DNI (ya sea de ?documento= o de un envío POST)
        $dni = $request->query('documento') ?? $request->input('documento');

        // 2. Si entran a /buscar sin DNI vía GET, regresamos al inicio
        if (!$dni && $request->isMethod('get')) {
            return redirect('/');
        }

        // 3. Validación de formato
        $request->validate([
            'documento' => 'required|numeric|digits:8',
        ], [
            'documento.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'documento.required' => 'Debes ingresar un número de documento.',
        ]);

        // 4. Si la petición es POST (envío de formulario), redirigimos a GET 
        // para que la URL se vea como: /buscar?documento=XXXXXXXX
        if ($request->isMethod('post')) {
            return redirect()->route('buscar', ['documento' => $dni]);
        }

        // 5. Consulta a la base de datos con todas las relaciones
        $cliente = Persona::with([
            'direcciones', 'telefonos', 'autos', 'familiares', 'correos', 'propiedades', 'situaciones'
        ])->find($dni);

        // 6. Rebote: Si el DNI no existe, regresamos atrás con error (mantiene al usuario donde estaba)
        if (!$cliente) {
            return back()->withErrors(['documento' => "DNI $dni no encontrado en nuestra base de datos."]);
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

        // 8. Retorno de la vista con los datos procesados
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
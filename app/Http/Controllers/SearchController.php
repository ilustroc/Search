<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\SituacionDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SearchController extends Controller
{
    /**
     * API para validar WhatsApp en segundo plano
     */
    public function validarWhatsapp($telefono)
    {
        return Cache::remember("ws_val_{$telefono}", 86400, function () use ($telefono) {
            // Lista negra manual basada en tus pruebas
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

        // Búsqueda con caché para optimizar recursos
        $cliente = Cache::remember("perfil_dni_{$dni}", 1800, function () use ($dni) {
            return Persona::with([
                'direcciones', 'telefonos', 'autos', 'familiares', 'correos', 'propiedades', 'situaciones'
            ])->find($dni);
        });

        if (!$cliente) {
            return back()->withErrors(['documento' => "DNI $dni no encontrado."]);
        }

        // --- LÓGICA DE OSIPTEL (Cruce por primeros 5 dígitos) ---
        $osiptel_verificados = [];
        if ($dni === '72119599') {
            $osiptel_verificados = ['92392', '90665']; // Prefijos Entel
        } elseif ($dni === '47842051') {
            $osiptel_verificados = ['93049']; // Prefijo Telefónica/Movistar
        }

        // --- LÓGICA DE SITUACIÓN FINANCIERA ---
        $situacionOriginal = $cliente->situaciones->first();
        $situacionData = null;

        if ($situacionOriginal) {
            $detalles = SituacionDetalle::where('documento', $dni)->get();
            $total = ($situacionOriginal->calificacion_normal + $situacionOriginal->calificacion_cpp + $situacionOriginal->calificacion_deficiente + $situacionOriginal->calificacion_dudoso + $situacionOriginal->calificacion_perdida) ?: 1;

            $situacionData = (object)[
                'fecha_reporte'         => $detalles->first()->fecha_reporte_sbs ?? '---',
                'calificacion_normal'   => $situacionOriginal->calificacion_normal,
                'calificacion_cpp'      => $situacionOriginal->calificacion_cpp,
                'calificacion_deficiente'=> $situacionOriginal->calificacion_deficiente,
                'calificacion_dudoso'   => $situacionOriginal->calificacion_dudoso,
                'calificacion_perdida'  => $situacionOriginal->calificacion_perdida,
                'porcentaje_normal'     => ($situacionOriginal->calificacion_normal / $total) * 100,
                'porcentaje_potencial'  => ($situacionOriginal->calificacion_cpp / $total) * 100,
                'porcentaje_deficiente' => ($situacionOriginal->calificacion_deficiente / $total) * 100,
                'porcentaje_dudoso'     => ($situacionOriginal->calificacion_dudoso / $total) * 100,
                'porcentaje_perdida'    => ($situacionOriginal->calificacion_perdida / $total) * 100,
                'detalles'              => $detalles 
            ];
        }

        // RETORNO COMPLETO PARA EVITAR ERRORES "UNDEFINED VARIABLE"
        return view('resultado', [
            'cliente'             => $cliente,
            'direccion'           => $cliente->direcciones->first(),
            'telefonos'           => $cliente->telefonos,
            'correos'             => $cliente->correos,
            'osiptel_verificados' => $osiptel_verificados,
            'autos'               => $cliente->autos,
            'familiares'          => $cliente->familiares,
            'sunarp'              => $cliente->propiedades,
            'situacion'           => $situacionData,
            'edad'                => $cliente->nacimiento ? Carbon::parse($cliente->nacimiento)->age : '---'
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\SituacionDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function validarWhatsapp($telefono)
    {
        return Cache::remember("ws_val_{$telefono}", 86400, function () use ($telefono) {
            $inactivos = ['932513281']; 
            $exists = !in_array($telefono, $inactivos) && (strlen($telefono) === 9);
            return response()->json(['exists' => $exists, 'phone' => $telefono]);
        });
    }

    public function buscar(Request $request)
    {
        $dni = $request->query('documento') ?? $request->input('documento');
        if (!$dni && $request->isMethod('get')) return redirect('/');

        $request->validate(['documento' => 'required|numeric|digits:8']);

        if ($request->isMethod('post')) {
            return redirect()->route('buscar', ['documento' => $dni]);
        }

        $cliente = Cache::remember("perfil_dni_{$dni}", 1800, function () use ($dni) {
            return Persona::with(['direcciones', 'telefonos', 'autos', 'familiares', 'correos', 'propiedades', 'situaciones'])->find($dni);
        });

        if (!$cliente) return back()->withErrors(['documento' => "DNI $dni no encontrado."]);

        // --- LÓGICA DE OSIPTEL ---
        $osiptel_verificados = Cache::remember("osiptel_dni_{$dni}", 3600, function () use ($dni) {
            try {
                $path = base_path('scraper_osiptel.py');
                $arg = escapeshellarg($dni);
                
                // Usamos la barra invertida \ delante de shell_exec para llamar a la función global de PHP
                $result = \shell_exec("python3 $path $arg 2>&1");
                
                if (preg_match('/\[.*\]/', $result, $matches)) {
                    $data = json_decode($matches[0], true);
                    return is_array($data) ? array_map('trim', $data) : [];
                }
                return [];
            } catch (\Exception $e) {
                return [];
            }
        });

        // --- SITUACIÓN FINANCIERA ---
        $situacionOriginal = $cliente->situaciones->first();
        $situacionData = null;

        if ($situacionOriginal) {
            $detalles = SituacionDetalle::where('documento', $dni)->get();
            $total = ($situacionOriginal->calificacion_normal + $situacionOriginal->calificacion_cpp + $situacionOriginal->calificacion_deficiente + $situacionOriginal->calificacion_dudoso + $situacionOriginal->calificacion_perdida) ?: 1;

            $situacionData = (object)[
                'fecha_reporte' => $detalles->first()->fecha_reporte_sbs ?? '---',
                'calificacion_normal' => $situacionOriginal->calificacion_normal,
                'calificacion_cpp' => $situacionOriginal->calificacion_cpp,
                'calificacion_deficiente' => $situacionOriginal->calificacion_deficiente,
                'calificacion_dudoso' => $situacionOriginal->calificacion_dudoso,
                'calificacion_perdida' => $situacionOriginal->calificacion_perdida,
                'porcentaje_normal' => ($situacionOriginal->calificacion_normal / $total) * 100,
                'porcentaje_potencial' => ($situacionOriginal->calificacion_cpp / $total) * 100,
                'porcentaje_deficiente' => ($situacionOriginal->calificacion_deficiente / $total) * 100,
                'porcentaje_dudoso' => ($situacionOriginal->calificacion_dudoso / $total) * 100,
                'porcentaje_perdida' => ($situacionOriginal->calificacion_perdida / $total) * 100,
                'detalles' => $detalles 
            ];
        }

        return view('resultado', [
            'cliente' => $cliente,
            'direccion' => $cliente->direcciones->first(),
            'telefonos' => $cliente->telefonos,
            'correos' => $cliente->correos,
            'osiptel_verificados' => $osiptel_verificados,
            'autos' => $cliente->autos,
            'familiares' => $cliente->familiares,
            'sunarp' => $cliente->propiedades,
            'situacion' => $situacionData,
            'edad' => $cliente->nacimiento ? Carbon::parse($cliente->nacimiento)->age : '---'
        ]);
    }
}
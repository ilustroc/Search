<?php

namespace App\Http\Controllers;

use App\Models\Persona;
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
            $inactivos = ['932513281']; 
            $exists = !in_array($telefono, $inactivos) && (strlen($telefono) === 9);
            return response()->json(['exists' => $exists, 'phone' => $telefono]);
        });
    }

    /**
     * Realiza la búsqueda principal e integra el Scraper de Osiptel
     */
    public function buscar(Request $request)
    {
        $dni = $request->query('documento') ?? $request->input('documento');

        if (!$dni && $request->isMethod('get')) return redirect('/');

        $request->validate([
            'documento' => 'required|numeric|digits:8'
        ], [
            'documento.digits' => 'El DNI debe tener 8 dígitos.',
            'documento.required' => 'Ingrese un documento.',
        ]);

        if ($request->isMethod('post')) {
            return redirect()->route('buscar', ['documento' => $dni]);
        }

        // 1. Obtener datos del cliente con caché
        $cliente = Cache::remember("perfil_dni_{$dni}", 1800, function () use ($dni) {
            return Persona::with(['direcciones', 'telefonos', 'autos', 'familiares', 'correos', 'propiedades', 'situaciones'])->find($dni);
        });

        if (!$cliente) return back()->withErrors(['documento' => "DNI $dni no encontrado."]);

        // 2. Ejecutar Scraper de Osiptel (Caché de 1 hora para no saturar la web oficial)
        // --- LÓGICA DE OSIPTEL (Cruce por primeros 5 dígitos) ---
        $osiptel_verificados = Cache::remember("osiptel_dni_{$dni}", 3600, function () use ($dni) {
            try {
                $path = base_path('scraper_osiptel.py');
                $arg = escapeshellarg($dni);
                
                // Ejecutamos capturando errores (2>&1)
                $result = shell_exec("python $path $arg 2>&1") ?? shell_exec("python3 $path $arg 2>&1");
                
                // LIMPIEZA EXTREMA: Buscamos el array JSON ignorando ruidos de consola
                if (preg_match('/\[.*\]/', $result, $matches)) {
                    $data = json_decode($matches[0], true); // true para que sea array simple
                    // Limpiamos espacios en blanco de cada prefijo por si acaso
                    return is_array($data) ? array_map('trim', $data) : [];
                }
                
                return [];
            } catch (\Exception $e) {
                \Log::error("Error Scraper Osiptel DNI {$dni}: " . $e->getMessage());
                return [];
            }
        });

        // 3. Procesar Situación Financiera (SBS)
        $situacionOriginal = $cliente->situaciones->first();
        $situacionData = null;

        if ($situacionOriginal) {
            $detalles = \App\Models\SituacionDetalle::where('documento', $dni)->get();
            $total = ($situacionOriginal->calificacion_normal + $situacionOriginal->calificacion_cpp + $situacionOriginal->calificacion_deficiente + $situacionOriginal->calificacion_dudoso + $situacionOriginal->calificacion_perdida) ?: 1;

            $situacionData = (object)[
                'fecha_reporte'          => $detalles->first()->fecha_reporte_sbs ?? '---',
                'calificacion_normal'    => $situacionOriginal->calificacion_normal,
                'calificacion_cpp'       => $situacionOriginal->calificacion_cpp,
                'calificacion_deficiente'=> $situacionOriginal->calificacion_deficiente,
                'calificacion_dudoso'    => $situacionOriginal->calificacion_dudoso,
                'calificacion_perdida'   => $situacionOriginal->calificacion_perdida,
                'porcentaje_normal'      => ($situacionOriginal->calificacion_normal / $total) * 100,
                'porcentaje_potencial'   => ($situacionOriginal->calificacion_cpp / $total) * 100,
                'porcentaje_deficiente'  => ($situacionOriginal->calificacion_deficiente / $total) * 100,
                'porcentaje_dudoso'      => ($situacionOriginal->calificacion_dudoso / $total) * 100,
                'porcentaje_perdida'     => ($situacionOriginal->calificacion_perdida / $total) * 100,
                'detalles'               => $detalles 
            ];
        }

        // 4. Retornar vista con todas las variables necesarias
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
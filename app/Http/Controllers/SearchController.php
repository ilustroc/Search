<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Procesa el formulario POST y redirige a una URL limpia.
     */
    public function procesarFormulario(Request $request)
    {
        $request->validate([
            'documento' => 'required|numeric',
            'tipo' => 'required|in:DNI,RUC'
        ]);

        // Redirigimos a la URL limpia: /buscar/12345678?tipo=DNI
        return redirect()->route('buscar.directo', [
            'documento' => $request->documento,
            'tipo' => $request->tipo
        ]);
    }

    /**
     * Muestra los resultados de la búsqueda.
     */
    public function buscar(Request $request, $documento)
    {
        $tipo = $request->query('tipo', 'DNI'); // Por defecto DNI si no viene en la URL

        // Validación extra de longitud según el tipo
        if ($tipo === 'DNI' && strlen($documento) !== 8) {
            return redirect('/')->withErrors(['msg' => 'El DNI debe tener 8 dígitos.']);
        }
        
        if ($tipo === 'RUC' && strlen($documento) !== 11) {
            return redirect('/')->withErrors(['msg' => 'El RUC debe tener 11 dígitos.']);
        }

        // --- AQUÍ IRÍA TU LÓGICA DE CONSULTA A LA API O BD ---
        // Ejemplo: $cliente = Cliente::where('numero', $documento)->first();
        
        $datosCliente = [
            'documento' => $documento,
            'tipo' => $tipo,
            'status' => 'Simulado desde Laravel 12'
        ];

        // Retornamos una vista con los resultados (debes crearla)
        // o por ahora devolvemos el JSON para probar
        return response()->json($datosCliente);
    }
}
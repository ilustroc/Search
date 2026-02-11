<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function buscar(Request $request, $documento)
    {
        // 1. Carga con todas las relaciones (Equivalente a joinedload)
        $cliente = Persona::with([
            'direcciones',
            'telefonos' => fn($q) => $q->orderBy('fecha_activacion', 'desc'),
            'autos',
            'familiares',
            'correos',
            'propiedades',
            'situaciones.detalles'
        ])->find($documento);

        if (!$cliente) {
            return view('no_encontrado', compact('documento'));
        }

        // 2. Preparar datos para la vista (Como en tu return render_template)
        return view('resultado', [
            'cliente' => $cliente,
            'edad' => $cliente->edad,
            'direccion' => $cliente->direcciones->first(),
            'telefonos' => $cliente->telefonos,
            'autos' => $cliente->autos,
            'familiares' => $cliente->familiares,
            'correos' => $cliente->correos,
            'sunarp' => $cliente->propiedades,
            'situacion' => $cliente->situaciones->first(),
        ]);
    }
}
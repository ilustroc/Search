<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Imports\PersonasImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function index() {
        return view('admin.import');
    }

    public function upload(Request $request) {
        $request->validate(['archivo' => 'required|mimes:csv,txt']);

        $import = new PersonasImport;
        Excel::import($import, $request->file('archivo'));

        if ($import->failures()->count() > 0) {
            return back()->with('import_errors', $import->failures());
        }

        return back()->with('success', '¡Carga masiva finalizada con éxito!');
    }

    public function truncate() {
        // Truncar es más rápido que Delete para limpiar tablas grandes
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Persona::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return back()->with('info', 'Base de datos limpiada. Lista para nueva carga.');
    }
}
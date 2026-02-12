<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Imports\{
    PersonasImport, TelefonosImport, DireccionesImport, 
    AutosImport, CorreosImport, FamiliaresImport,
    SbsResumenImport, SbsDetalleImport, SueldosImport, SunarpImport
};

class ImportController extends Controller
{
    public function index() {
        return view('admin.import');
    }

    public function upload(Request $request, $tipo) {
        $request->validate(['archivo' => 'required|mimes:csv,txt']);
        ini_set('max_execution_time', 600); 

        $importClass = match($tipo) {
            'personas'     => new PersonasImport,
            'telefonos'    => new TelefonosImport,
            'direcciones'  => new DireccionesImport,
            'autos'        => new AutosImport,
            'correos'      => new CorreosImport,
            'familiares'   => new FamiliaresImport,
            'sbs_resumen'  => new SbsResumenImport,
            'sbs_detalle'  => new SbsDetalleImport,
            'sueldos'      => new SueldosImport,
            'sunarp'       => new SunarpImport,
            default        => abort(404)
        };

        Excel::import($importClass, $request->file('archivo'));
        return back()->with('success', "Importación de " . strtoupper($tipo) . " completada.");
    }

    public function truncate($tabla) {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Mapeo de nombre de ruta a nombre real de tabla en DB
        $tableRealName = match($tabla) {
            'sunarp' => 'sunarp_partidas',
            'sbs_resumen' => 'sbs_resumen',
            'sbs_detalle' => 'sbs_detalle',
             default => $tabla
        };
        
        DB::table($tableRealName)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return back()->with('info', "Tabla $tabla limpiada exitosamente.");
    }
}
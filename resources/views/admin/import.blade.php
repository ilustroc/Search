{{-- resources/views/admin/import.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-10 pb-20">
    <div class="flex flex-col gap-2">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Data Management Center</h2>
        <p class="text-slate-500 font-medium">Carga masiva y mantenimiento de bases de datos mensuales.</p>
    </div>

    @php
        $secciones = [
            'Identidad y Contacto' => [
                'personas' => 'Datos maestros de clientes',
                'telefonos' => 'Registros telefónicos (Bitel, Claro, etc)',
                'direcciones' => 'Domicilios y departamentos',
                'correos' => 'Cuentas de email registradas',
                'familiares' => 'Vínculos y referencias'
            ],
            'Activos y Patrimonio' => [
                'autos' => 'Vehículos y placas (clase, marca)',
                'sunarp' => 'Partidas registrales e inmuebles',
                'sueldos' => 'Estimación de ingresos mensuales'
            ],
            'Análisis SBS' => [
                'sbs_resumen' => 'Calificaciones (Normal, CPP, etc)',
                'sbs_detalle' => 'Deudas desglosadas por banco'
            ]
        ];
    @endphp

    @foreach($secciones as $titulo => $modulos)
        <div class="space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 pl-2">{{ $titulo }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($modulos as $id => $desc)
                    <div class="card-light flex flex-col justify-between group hover:border-ig-dark/20 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-black text-slate-800 uppercase tracking-wider">{{ str_replace('_', ' ', $id) }}</h4>
                                <span class="h-2 w-2 rounded-full bg-slate-200 group-hover:bg-ig-dark transition-colors"></span>
                            </div>
                            <p class="text-[11px] text-slate-500 font-medium leading-relaxed mb-6">{{ $desc }}</p>
                            
                            <form action="{{ route('admin.import.upload', $id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <input type="file" name="archivo" class="block w-full text-[10px] text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-slate-100 file:text-slate-600 hover:file:bg-slate-200 cursor-pointer" required>
                                <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded-xl font-bold text-[11px] hover:bg-ig-dark transition-all shadow-sm">
                                    CARGAR CSV
                                </button>
                            </form>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-50">
                            <form action="{{ route('admin.import.truncate', $id) }}" method="POST" onsubmit="return confirm('¿Eliminar todos los datos de {{ $id }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[10px] font-bold text-rose-400 hover:text-rose-600 transition-colors uppercase tracking-tighter">
                                    Vaciado Rápido (Truncate)
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
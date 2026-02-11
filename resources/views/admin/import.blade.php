@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Panel de Administración</h2>
        <span class="px-3 py-1 bg-ig-dark/10 text-ig-dark rounded-full text-xs font-bold uppercase">Mantenimiento</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card-light border-ig-dark/20">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Cargar Clientes (CSV)</h3>
            <form action="{{ route('admin.import.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <input type="file" name="archivo" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-ig-dark/10 file:text-ig-dark hover:file:bg-ig-dark/20 cursor-pointer" required>
                    <button type="submit" class="w-full bg-ig-dark text-white py-3 rounded-2xl font-bold shadow-lg hover:bg-ig-dark/90 transition-all">
                        Iniciar Carga Masiva
                    </button>
                </div>
            </form>
        </div>

        <div class="card-light border-rose-100 bg-rose-50/30">
            <h3 class="text-lg font-bold text-rose-800 mb-4">Zona de Peligro</h3>
            <p class="text-sm text-rose-600/70 mb-6 font-medium">Esta acción eliminará permanentemente todos los clientes actuales para permitir una carga limpia.</p>
            <form action="{{ route('admin.import.truncate') }}" method="POST" onsubmit="return confirm('¿Estás seguro de vaciar TODA la base de datos? Esta acción es irreversible.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-rose-600 text-white py-3 rounded-2xl font-bold hover:bg-rose-700 transition-all shadow-md">
                    Truncar Tabla Personas
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
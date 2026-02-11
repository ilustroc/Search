@extends('layouts.app') {{-- ESTA LÍNEA ES OBLIGATORIA PARA QUE NO SALGA BLANCO --}}

@section('title', 'Resultado Cliente')

@section('content')
<div class="space-y-6">
    <x-header-cliente :cliente="$cliente" :direccion="$direccion" :edad="$edad" />

    <div id="tab-principal" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-4 space-y-6">
                <x-datos-secundarios :cliente="$cliente" />
                <x-afp :cliente="$cliente" />
                <x-correos :correos="$correos" />
            </div>
            <div class="lg:col-span-8 space-y-6">
                <x-telefonos :telefonos="$telefonos" />
                <x-direcciones :direcciones="$cliente->direcciones" />
                <x-autos :autos="$autos" />
                <x-familiares :familiares="$familiares" />
                <x-sunarp :propiedades="$sunarp" />
            </div>
        </div>
    </div>

    <div id="tab-financiera" class="tab-content hidden">
        <x-situacion-financiera :situacion="$situacion" />
    </div>
</div>
@endsection
@extends('layouts.app')

@push('head')
    @vite(['resources/css/resultado.css', 'resources/js/resultado.js'])
@endpush

@section('content')
<div class="space-y-4">
    {{-- Tu contenido idéntico al original --}}
    <section class="card-light !p-4 sm:!p-5">
        <x-header-cliente :cliente="$cliente" :direccion="$direccion" :edad="$edad" />
    </section>

    <div class="flex items-center justify-start">
        <div class="inline-grid grid-cols-2 rounded-2xl bg-slate-200/50 p-1 border border-slate-200 w-full sm:w-[420px]">
            <button
                type="button"
                class="tab-btn inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold transition-all"
                data-tab="principal"
                aria-selected="true"
                onclick="showTab('principal', this)">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="12" cy="7" r="4" stroke-width="2"/>
                </svg>
                <span>Principal</span>
            </button>

            <button
                type="button"
                class="tab-btn inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold transition-all"
                data-tab="financiera"
                aria-selected="false"
                onclick="showTab('financiera', this)">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M3 7.5A2.5 2.5 0 0 1 5.5 5h13A2.5 2.5 0 0 1 21 7.5V18a1 1 0 0 1-1 1H6a3 3 0 0 1-3-3V7.5Z" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M21 11h-5a2 2 0 0 0 0 4h5" stroke-width="2"/>
                    <circle cx="16.5" cy="13" r="0.75" fill="currentColor"/>
                </svg>
                <span>Situación Financiera</span>
            </button>
        </div>
    </div>

    <div id="tab-principal" class="tab-content" data-tab-content>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-4 space-y-6">
                <section class="card-light">
                    <x-datos-secundarios :cliente="$cliente" />
                </section>

                <section class="card-light">
                    <x-afp :cliente="$cliente" />
                </section>

                <section class="card-light">
                    <x-correos :correos="$correos" />
                </section>
            </div>

            <div class="lg:col-span-8 space-y-6">
                <x-telefonos :telefonos="$telefonos" />
                
                <x-direcciones :direcciones="$cliente->direcciones" />

                <x-autos :autos="$autos" />

                <x-sunarp :propiedades="$sunarp" />

                <x-familiares :familiares="$familiares" />
            </div>
        </div>
    </div>

    <div id="tab-financiera" class="tab-content hidden" data-tab-content>
        <section class="card-light">
            <x-situacion-financiera :situacion="$situacion" />
        </section>
    </div>

</div>
@endsection
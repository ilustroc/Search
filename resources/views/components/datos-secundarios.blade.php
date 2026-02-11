@props(['cliente'])

<div class="space-y-6">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-bold tracking-widest text-slate-400 uppercase">Datos Secundarios</h4>
            <p class="mt-1 text-[12px] text-slate-500 font-medium">Información biográfica y familiar.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        
        {{-- Fila 1: Estado Civil y Sexo --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-ig-dark/20 transition-colors">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight mb-1">Estado Civil</p>
                <p class="text-sm font-bold text-slate-700">{{ $cliente->estado_civil ?? '---' }}</p>
            </div>
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-ig-dark/20 transition-colors">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight mb-1">Sexo</p>
                <p class="text-sm font-bold text-slate-700">
                    {{ $cliente->sexo == 1 ? 'MASCULINO' : ($cliente->sexo == 2 ? 'FEMENINO' : '---') }}
                </p>
            </div>
        </div>

        {{-- Fila 2: Fecha de Nacimiento y Lugar --}}
        <div class="grid grid-cols-1 gap-4">
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-ig-dark/20 transition-colors">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight mb-1">Fecha de Nacimiento</p>
                <p class="text-sm font-bold text-slate-700">
                    {{ $cliente->nacimiento ? \Carbon\Carbon::parse($cliente->nacimiento)->format('d/m/Y') : '---' }}
                </p>
            </div>
            {{-- Basado en tu SQL, recuperamos el lugar (usando ubigeo o direccion_raw como referencia) --}}
            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-ig-dark/20 transition-colors">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight mb-1">Lugar de Nacimiento</p>
                <p class="text-sm font-bold text-slate-700">{{ $cliente->direccion_raw ?? '---' }}</p>
            </div>
        </div>

        {{-- Fila 3: Información de Padres (Tal cual tu SQL original) --}}
        <div class="space-y-3 pt-2 border-t border-slate-100">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m14-10a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none mb-1">Padre</p>
                    <p class="text-sm font-bold text-slate-700 truncate">{{ $cliente->padre ?? '---' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m14-10a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none mb-1">Madre</p>
                    <p class="text-sm font-bold text-slate-700 truncate">{{ $cliente->madre ?? '---' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
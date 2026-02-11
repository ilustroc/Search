@props(['cliente', 'direccion', 'edad'])

<div class="flex flex-col sm:flex-row sm:items-center gap-6">
    <div class="shrink-0">
        <div class="h-24 w-24 rounded-3xl border-4 border-white bg-slate-100 overflow-hidden shadow-sm ring-1 ring-slate-200">
            <img src="{{ $cliente->foto ?? asset('img/user-placeholder.png') }}"
                 alt="Foto de {{ $cliente->nombres }}"
                 class="h-full w-full object-cover" />
        </div>
    </div>

    <div class="min-w-0 flex-1">

        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-800 truncate">
            {{ $cliente->nombre_completo ?? 'Cliente no identificado' }}
        </h2>

        <div class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm">
            
            {{-- DNI --}}
            <div class="flex items-center gap-2 group">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-400 group-hover:text-ig-dark transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7Z"/>
                        <path d="M8 9h5M8 13h8M8 17h6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none mb-1">Documento</p>
                    <p class="font-bold text-slate-700 leading-none">{{ $cliente->documento }}</p>
                </div>
            </div>

            {{-- Ubicación --}}
            <div class="flex items-center gap-2 group">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-400 group-hover:text-ig-dark transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z"/>
                        <circle cx="12" cy="11" r="2.5"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none mb-1">Residencia</p>
                    <p class="font-bold text-slate-700 leading-none">
                        {{ $direccion ? "{$direccion->departamento}, {$direccion->distrito}" : "No registrada" }}
                    </p>
                </div>
            </div>

            {{-- Edad --}}
            <div class="flex items-center gap-2 group">
                <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-400 group-hover:text-ig-dark transition-colors">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none mb-1">Edad Actual</p>
                    <p class="font-bold text-slate-700 leading-none">{{ $edad }} años</p>
                </div>
            </div>

        </div>
    </div>
</div>
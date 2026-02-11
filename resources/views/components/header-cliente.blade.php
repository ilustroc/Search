<div class="flex flex-col sm:flex-row sm:items-center gap-5">
    <div class="shrink-0">
        <div class="h-20 w-20 rounded-2xl border border-white/12 bg-white/10 overflow-hidden shadow-sm">
            <img src="{{ $cliente->foto ?? asset('images/user-placeholder.png') }}"
                 alt="Foto del Cliente"
                 class="h-full w-full object-cover" />
        </div>
    </div>

    <div class="min-w-0 flex-1">
        <div class="text-[11px] font-semibold tracking-[0.22em] text-white/55 uppercase">
            Cliente
        </div>

        <h2 class="mt-1 text-xl sm:text-2xl font-extrabold tracking-tight text-white truncate">
            {{ $cliente->nombre_completo ?? 'Cliente' }}
        </h2>

        <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-white/70">
            <span class="inline-flex items-center gap-2">
                <svg class="h-4 w-4 text-white/55" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M8 9h5M8 13h8M8 17h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span class="font-semibold text-white/85">DNI:</span>
                <span class="text-white/90">{{ $cliente->documento }}</span>
            </span>

            <span class="text-white/25">•</span>

            <span class="inline-flex items-center gap-2">
                <svg class="h-4 w-4 text-white/55" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 22s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <circle cx="12" cy="11" r="2.5" stroke="currentColor" stroke-width="2"/>
                </svg>
                <span class="font-semibold text-white/85">Ubicación:</span>
                <span class="text-white/90">
                    {{ $direccion ? "{$direccion->departamento}, {$direccion->distrito}" : "—" }}
                </span>
            </span>

            <span class="text-white/25">•</span>

            <span class="inline-flex items-center gap-2">
                <svg class="h-4 w-4 text-white/55" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7 21h10a2 2 0 0 0 2-2v-7H5v7a2 2 0 0 0 2 2Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M7 7h10M8 3v4M16 3v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span class="font-semibold text-white/85">Edad:</span>
                <span class="text-white/90">{{ $edad }} años</span>
            </span>
        </div>
    </div>
</div>
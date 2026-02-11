@props(['cliente'])

<div class="space-y-4">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-bold tracking-widest text-slate-400 uppercase">AFP</h4>
            <p class="mt-1 text-[12px] text-slate-500 font-medium">Información de afiliación previsional.</p>
        </div>
    </div>

    @if ($cliente->afp)
        {{-- Lista de datos con diseño Light --}}
        <dl class="mt-4 divide-y divide-slate-100 rounded-2xl border border-slate-200 bg-slate-50/50 overflow-hidden">
            {{-- Nombre de la AFP --}}
            <div class="flex items-center justify-between gap-4 px-4 py-3 hover:bg-white transition-colors">
                <dt class="text-sm font-medium text-slate-500">Administradora</dt>
                <dd class="text-sm font-bold text-slate-800 text-right">{{ $cliente->afp->nombre ?? '---' }}</dd>
            </div>

            {{-- Tipo de Comisión/Fondo --}}
            <div class="flex items-center justify-between gap-4 px-4 py-3 hover:bg-white transition-colors">
                <dt class="text-sm font-medium text-slate-500">Tipo</dt>
                <dd class="text-sm font-bold text-slate-800 text-right">
                    <span class="inline-flex items-center rounded-lg bg-ig-dark/5 px-2 py-0.5 text-[11px] font-bold text-ig-dark ring-1 ring-ig-dark/10">
                        {{ $cliente->afp->tipo ?? '---' }}
                    </span>
                </dd>
            </div>

            {{-- Fecha de Afiliación --}}
            <div class="flex items-center justify-between gap-4 px-4 py-3 hover:bg-white transition-colors">
                <dt class="text-sm font-medium text-slate-500">Fecha de afiliación</dt>
                <dd class="text-sm font-bold text-slate-800 text-right">{{ $cliente->afp->fecha_afiliacion ?? '---' }}</dd>
            </div>
        </dl>
    @else
        {{-- Estado Vacío --}}
        <div class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 flex items-center gap-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <p class="text-sm text-slate-400 font-medium">No se detectó afiliación a AFP.</p>
        </div>
    @endif
</div>
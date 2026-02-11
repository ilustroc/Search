@props(['cliente'])
<div>
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-semibold tracking-widest text-white/70 uppercase">AFP</h4>
            <p class="mt-1 text-[12px] text-white/45">Información de afiliación.</p>
        </div>
    </div>

    @if ($cliente->afp)
        <dl class="mt-4 divide-y divide-white/10 rounded-2xl border border-white/10 bg-black/20">
            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <dt class="text-sm text-white/70">Nombre</dt>
                <dd class="text-sm font-semibold text-white text-right">{{ $cliente->afp->nombre ?? '---' }}</dd>
            </div>
            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <dt class="text-sm text-white/70">Tipo</dt>
                <dd class="text-sm font-semibold text-white text-right">{{ $cliente->afp->tipo ?? '---' }}</dd>
            </div>
            <div class="flex items-center justify-between gap-4 px-4 py-3">
                <dt class="text-sm text-white/70">Fecha de afiliación</dt>
                <dd class="text-sm font-semibold text-white text-right">{{ $cliente->afp->fecha_afiliacion ?? '---' }}</dd>
            </div>
        </dl>
    @else
        <div class="mt-4 rounded-2xl border border-white/10 bg-black/20 px-4 py-4 text-sm text-white/65">
            Sin AFP.
        </div>
    @endif
</div>
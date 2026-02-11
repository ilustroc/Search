@props(['cliente'])
<div>
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-semibold tracking-widest text-white/70 uppercase">Datos secundarios</h4>
            <p class="mt-1 text-[12px] text-white/45">Información general del cliente.</p>
        </div>
    </div>

    <dl class="mt-4 divide-y divide-white/10 rounded-2xl border border-white/10 bg-black/20">
        {{-- Estado Civil --}}
        <div class="flex items-center justify-between gap-4 px-4 py-3">
            <dt class="flex items-center gap-3 text-sm text-white/70">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/5 border border-white/10">
                    <svg class="h-4 w-4 text-white/65" viewBox="0 0 24 24" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"/><path d="M16 3.5a4 4 0 1 1-8 0" stroke="currentColor" stroke-width="2"/></svg>
                </span>
                Estado civil
            </dt>
            <dd class="text-sm font-semibold text-white">{{ $cliente->estado_civil ?? '---' }}</dd>
        </div>

        {{-- Sexo --}}
        <div class="flex items-center justify-between gap-4 px-4 py-3">
            <dt class="flex items-center gap-3 text-sm text-white/70">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/5 border border-white/10">
                    <svg class="h-4 w-4 text-white/65" viewBox="0 0 24 24" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/></svg>
                </span>
                Sexo
            </dt>
            <dd class="text-sm font-semibold text-white">{{ $cliente->sexo == 1 ? 'MASCULINO' : ($cliente->sexo == 2 ? 'FEMENINO' : '---') }}</dd>
        </div>

        {{-- Fecha Nacimiento --}}
        <div class="flex items-center justify-between gap-4 px-4 py-3">
            <dt class="flex items-center gap-3 text-sm text-white/70">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/5 border border-white/10">
                    <svg class="h-4 w-4 text-white/65" viewBox="0 0 24 24" fill="none"><path d="M7 3v2M17 3v2M4 7h16v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="2"/><path d="M4 11h16" stroke="currentColor" stroke-width="2"/></svg>
                </span>
                Fecha de nacimiento
            </dt>
            <dd class="text-sm font-semibold text-white">{{ $cliente->nacimiento ? \Carbon\Carbon::parse($cliente->nacimiento)->format('d/m/Y') : '---' }}</dd>
        </div>
    </dl>
</div>
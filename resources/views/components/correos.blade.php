@props(['correos'])

<div class="space-y-4">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-bold tracking-widest text-slate-400 uppercase">Correos electrónicos</h4>
            <p class="mt-1 text-[12px] text-slate-500 font-medium">Canales de contacto registrados.</p>
        </div>
    </div>

    @if($correos && count($correos) > 0)
        {{-- Lista de correos con diseño Light --}}
        <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50/50 overflow-hidden shadow-sm">
            <ul class="divide-y divide-slate-100">
                @foreach($correos as $correo)
                    <li class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-white transition-colors group">
                        <svg class="h-4 w-4 text-slate-300 group-hover:text-ig-dark transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <span class="font-medium">{{ $correo->correo }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        {{-- Estado Vacío --}}
        <div class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 flex items-center gap-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="text-sm text-slate-400 font-medium">No se encontraron correos electrónicos.</p>
        </div>
    @endif
</div>
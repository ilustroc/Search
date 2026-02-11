@props(['familiares'])

<div class="space-y-4">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-bold tracking-widest text-slate-400 uppercase">Familiares</h4>
            <p class="mt-1 text-[12px] text-slate-500 font-medium">Referencias y vínculos familiares detectados.</p>
        </div>
        @if(count($familiares) > 0)
            <div class="hidden sm:inline-flex items-center rounded-lg bg-ig-dark/5 px-2.5 py-1 text-[10px] font-bold text-ig-dark ring-1 ring-ig-dark/10">
                {{ count($familiares) }} Registro(s)
            </div>
        @endif
    </div>

    @if(count($familiares) > 0)
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($familiares as $familiar)
                <div class="group rounded-2xl border border-slate-200 bg-slate-50/50 p-4 hover:bg-white hover:border-ig-dark/20 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="shrink-0">
                            <img src="{{ asset('img/user-placeholder.png') }}" 
                                 alt="Avatar" 
                                 class="h-12 w-12 rounded-xl border-2 border-white bg-slate-100 object-cover shadow-sm group-hover:scale-105 transition-transform" />
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-bold text-slate-800 truncate group-hover:text-ig-dark transition-colors">
                                {{ $familiar->nombre_fam ?? '---' }}
                            </div>
                            
                            <div class="mt-1 flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                <span class="bg-slate-200/50 px-1.5 py-0.5 rounded text-slate-600">DNI: {{ $familiar->documento_fam ?? '---' }}</span>
                                <span class="text-slate-300">•</span>
                                <span class="text-ig-dark/70 uppercase tracking-wider font-bold">{{ $familiar->tipo_fam ?? '---' }}</span>
                            </div>

                            {{-- Fecha de Nacimiento (Restaurada del original) --}}
                            <div class="mt-1 text-[11px] text-slate-400 flex items-center gap-1">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Nacimiento: {{ $familiar->f_nac_fam ?? '---' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <p class="text-sm text-slate-400 font-medium">No se encontraron referencias familiares vinculadas.</p>
        </div>
    @endif
</div>
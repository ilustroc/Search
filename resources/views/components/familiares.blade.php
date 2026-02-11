@props(['familiares'])
<div>
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-semibold tracking-widest text-white/70 uppercase">Familiares</h4>
            <p class="mt-1 text-[12px] text-white/45">Referencias familiares asociadas.</p>
        </div>
        @if(count($familiares) > 0)
            <div class="hidden sm:inline-flex items-center rounded-xl border border-white/10 bg-white/5 px-3 py-1 text-[11px] text-white/60">
                {{ count($familiares) }} registro(s)
            </div>
        @endif
    </div>

    @if(count($familiares) > 0)
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($familiares as $familiar)
                <div class="rounded-2xl border border-white/10 bg-black/20 p-4 hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/user-placeholder.png') }}" alt="Avatar" class="h-10 w-10 rounded-2xl border border-white/10 object-cover" />
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-white truncate">{{ $familiar->nombre_fam ?? '---' }}</div>
                            <div class="mt-1 text-[12px] text-white/60">
                                DNI: <span class="text-white/75 font-semibold">{{ $familiar->documento_fam ?? '---' }}</span>
                                <span class="px-1 text-white/30">•</span>
                                {{ $familiar->tipo_fam ?? '---' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="mt-4 rounded-2xl border border-white/10 bg-black/20 px-4 py-4 text-sm text-white/65">
            No se encontraron familiares.
        </div>
    @endif
</div>
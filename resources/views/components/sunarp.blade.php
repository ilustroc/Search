@props(['propiedades'])
<details class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl overflow-hidden">
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-white/5 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                <svg class="h-5 w-5 text-white/75" viewBox="0 0 24 24" fill="none">
                    <path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-6Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M14 2v6h6M9 13h6M9 17h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </span>
            <div class="leading-tight">
                <div class="text-sm font-semibold text-white">SUNARP</div>
                <div class="text-[12px] text-white/50">{{ count($propiedades) }} registro(s)</div>
            </div>
        </div>
        <svg class="h-5 w-5 text-white/60 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none">
            <path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </summary>
    <div class="px-5 pb-5 pt-2">
        @if(count($propiedades) > 0)
            <div class="rounded-2xl border border-white/10 bg-black/20 overflow-hidden overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-white/5 text-white/70">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Partida</th>
                            <th class="px-4 py-3 text-left font-semibold">Zona</th>
                            <th class="px-4 py-3 text-left font-semibold">Oficina</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($propiedades as $p)
                            <tr class="text-white/85 hover:bg-white/5 transition">
                                <td class="px-4 py-3 font-semibold text-white">{{ $p->partida_registral ?? '---' }}</td>
                                <td class="px-4 py-3">{{ $p->zona_registral ?? '---' }}</td>
                                <td class="px-4 py-3">{{ $p->oficina ?? '---' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-4 text-sm text-white/65">Sin registros.</div>
        @endif
    </div>
</details>
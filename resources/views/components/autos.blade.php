@props(['autos'])
<details class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl overflow-hidden">
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-white/5 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                <svg class="h-5 w-5 text-white/75" viewBox="0 0 24 24" fill="none"><path d="M3 13l2-6a2 2 0 0 1 2-1h10a2 2 0 0 1 2 1l2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M5 13h14v5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-5Z" stroke="currentColor" stroke-width="2"/><path d="M7.5 18.5h.01M16.5 18.5h.01" stroke="currentColor" stroke-width="3"/></svg>
            </span>
            <div class="leading-tight">
                <div class="text-sm font-semibold text-white">Autos</div>
                <div class="text-[12px] text-white/50">{{ count($autos) }} registrado(s)</div>
            </div>
        </div>
        <svg class="h-5 w-5 text-white/60 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2"/></svg>
    </summary>
    <div class="px-5 pb-5 pt-2">
        @if(count($autos) > 0)
            <div class="rounded-2xl border border-white/10 bg-black/20 overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-white/5 text-white/70">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Placa</th>
                            <th class="px-4 py-3 text-left font-semibold">Marca</th>
                            <th class="px-4 py-3 text-left font-semibold">Compra</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($autos as $a)
                        <tr class="text-white/85 hover:bg-white/5 transition">
                            <td class="px-4 py-3 font-semibold text-white">{{ $a->placa ?? '---' }}</td>
                            <td class="px-4 py-3">{{ $a->marca ?? '---' }}</td>
                            <td class="px-4 py-3 text-white/75">{{ $a->compra ?? '---' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-4 text-sm text-white/65">Sin datos.</div>
        @endif
    </div>
</details>
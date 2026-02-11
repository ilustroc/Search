@props(['telefonos'])
<details class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl overflow-hidden" open>
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-white/5 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                <svg class="h-5 w-5 text-white/75" viewBox="0 0 24 24" fill="none"><path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 11.2 19a19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.6a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.5-1.2a2 2 0 0 1 2.1-.5c.8.3 1.7.5 2.6.6A2 2 0 0 1 22 16.9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            <div class="leading-tight">
                <div class="text-sm font-semibold text-white">Teléfonos</div>
                <div class="text-[12px] text-white/50">{{ count($telefonos) }} registrado(s)</div>
            </div>
        </div>
        <svg class="h-5 w-5 text-white/60 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
    </summary>

    <div class="px-5 pb-5 pt-2">
        @if(count($telefonos) > 0)
            <div class="rounded-2xl border border-white/10 bg-black/20 overflow-hidden overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-white/5 text-white/70">
                        <tr>
                            <th class="px-4 py-3 text-left">Teléfono</th>
                            <th class="px-4 py-3 text-left">Operador</th>
                            <th class="px-4 py-3 text-left">Yape</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($telefonos as $tel)
                            <tr class="text-white/85 hover:bg-white/5 transition">
                                <td class="px-4 py-3 font-semibold text-white">{{ $tel->telefono }}</td>
                                <td class="px-4 py-3">{{ $tel->origen ?? '---' }}</td>
                                <td class="px-4 py-3">
                                    @if($tel->yape)
                                        <span class="inline-flex items-center gap-1 rounded-xl border border-emerald-400/20 bg-emerald-500/10 px-3 py-1 text-[12px] font-semibold text-emerald-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span> Sí
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-xl border border-white/10 bg-white/5 px-3 py-1 text-[12px] text-white/70">
                                            No
                                        </span>
                                    @endif
                                </td>
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
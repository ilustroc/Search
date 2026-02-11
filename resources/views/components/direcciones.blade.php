@props(['direcciones'])
<details class="group rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl overflow-hidden">
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-white/5 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-white/5 border border-white/10">
                <svg class="h-5 w-5 text-white/75" viewBox="0 0 24 24" fill="none"><path d="M12 21s7-4.4 7-11a7 7 0 0 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="2"/></svg>
            </span>
            <div class="leading-tight">
                <div class="text-sm font-semibold text-white">Direcciones</div>
                <div class="text-[12px] text-white/50">{{ count($direcciones) }} registrada(s)</div>
            </div>
        </div>
        <svg class="h-5 w-5 text-white/60 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2"/></svg>
    </summary>
    <div class="px-5 pb-5 pt-2">
        @if(count($direcciones) > 0)
            <div class="rounded-2xl border border-white/10 bg-black/20 overflow-hidden overflow-x-auto">
                <table class="min-w-full text-sm text-white/85">
                    <thead class="bg-white/5 text-white/70">
                        <tr>
                            <th class="px-4 py-3 text-left">Dirección</th>
                            <th class="px-4 py-3 text-left">Distrito</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($direcciones as $d)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-4 py-3 font-semibold text-white">{{ $d->direccion ?? '---' }}</td>
                                <td class="px-4 py-3">{{ $d->distrito ?? '---' }}</td>
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
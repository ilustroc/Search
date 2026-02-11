@props(['propiedades'])

<details class="group rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 border border-slate-200 text-slate-500">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-6Z" />
                    <path d="M14 2v6h6M9 13h6M9 17h6" />
                </svg>
            </span>

            <div class="leading-tight">
                <div class="text-sm font-bold text-slate-800">SUNARP</div>
                <div class="text-[11px] font-medium text-slate-400">
                    {{ count($propiedades) }} registro(s) de propiedad inmueble
                </div>
            </div>
        </div>

        <svg class="h-5 w-5 text-slate-300 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </summary>

    <div class="px-5 pb-5 pt-2">
        @if(count($propiedades) > 0)
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px] w-16">Nro</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Partida Registral</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Zona Registral</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Oficina</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach($propiedades as $p)
                                <tr class="text-slate-600 hover:bg-white transition-colors">
                                    <td class="px-4 py-3 text-slate-400 font-medium">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 font-bold text-slate-900">
                                        {{ $p->partida_registral ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $p->zona_registral ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-lg bg-slate-200/50 px-2.5 py-1 text-[11px] font-bold text-slate-600 ring-1 ring-slate-200">
                                            {{ $p->oficina ?? '---' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-400 font-medium">
                Sin registros de propiedades encontrados.
            </div>
        @endif
    </div>
</details>
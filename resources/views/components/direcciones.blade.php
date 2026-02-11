@props(['direcciones'])

<details class="group rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 border border-slate-200 text-slate-500">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21s7-4.4 7-11a7 7 0 0 0-14 0c0 6.6 7 11 7 11Z"/>
                    <circle cx="12" cy="10" r="2.5"/>
                </svg>
            </span>

            <div class="leading-tight">
                <div class="text-sm font-bold text-slate-800">Direcciones</div>
                <div class="text-[11px] font-medium text-slate-400">
                    {{ count($direcciones) }} registrada(s) en base de datos
                </div>
            </div>
        </div>

        <svg class="h-5 w-5 text-slate-300 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </summary>

    <div class="px-5 pb-5 pt-2">
        @if(count($direcciones) > 0)
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Dirección</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Departamento</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Provincia</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Distrito</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach($direcciones as $d)
                                <tr class="text-slate-600 hover:bg-white transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-900">
                                        {{ $d->direccion ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $d->departamento ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $d->provincia ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $d->distrito ?? '---' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-400 font-medium">
                No hay direcciones registradas para este cliente.
            </div>
        @endif
    </div>
</details>
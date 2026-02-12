@props(['telefonos'])

<details class="group rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden" open>
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 border border-slate-200 text-slate-500">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 11.2 19a19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.6a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.5-1.2a2 2 0 0 1 2.1-.5c.8.3 1.7.5 2.6.6A2 2 0 0 1 22 16.9Z"/>
                </svg>
            </span>

            <div class="leading-tight">
                <div class="text-sm font-bold text-slate-800">Teléfonos</div>
                <div class="text-[11px] font-medium text-slate-400">
                    {{ count($telefonos) }} registro(s) detectado(s)
                </div>
            </div>
        </div>

        <svg class="h-5 w-5 text-slate-300 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </summary>

    <div class="px-5 pb-5 pt-2">
        @if(count($telefonos) > 0)
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Teléfono</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Operador</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Fecha data</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Tipo</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Yape</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Situación</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach($telefonos as $tel)
                                <tr class="text-slate-600 hover:bg-white transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-900">
                                        {{ $tel->telefono }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $tel->origen ?? '---' }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-500 font-medium">
                                        {{ $tel->fecha_act_raw ?? '---' }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-lg bg-slate-200/50 px-2 py-1 text-[11px] font-bold text-slate-600 ring-1 ring-slate-200">
                                            {{ $tel->tipo ?? '---' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        @if($tel->yape)
                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 px-2 py-1 text-[11px] font-bold text-emerald-700 ring-1 ring-emerald-600/20">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Sí
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2 py-1 text-[11px] font-bold text-slate-400 ring-1 ring-slate-200">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="font-medium {{ $tel->situacion == 'ACTIVO' ? 'text-emerald-600' : 'text-slate-500' }}">
                                            {{ $tel->situacion ?? '---' }}
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
                No se encontraron registros telefónicos.
            </div>
        @endif
    </div>
</details>
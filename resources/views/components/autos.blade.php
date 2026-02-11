@props(['autos'])

<details class="group rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 border border-slate-200 text-slate-500">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 13l2-6a2 2 0 0 1 2-1h10a2 2 0 0 1 2 1l2 6" />
                    <path d="M5 13h14v5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-5Z" />
                    <path d="M7.5 18.5h.01M16.5 18.5h.01" stroke-width="3" />
                </svg>
            </span>

            <div class="leading-tight">
                <div class="text-sm font-bold text-slate-800">Autos</div>
                <div class="text-[11px] font-medium text-slate-400">
                    {{ count($autos) }} vehículo(s) registrado(s)
                </div>
            </div>
        </div>

        <svg class="h-5 w-5 text-slate-300 transition-transform group-open:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </summary>

    <div class="px-5 pb-5 pt-2">
        @if(count($autos) > 0)
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-100/50 text-slate-500 border-b border-slate-200">
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Placa</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Marca</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Clase</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Compra</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Fabricación</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Tipo</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach($autos as $a)
                                <tr class="text-slate-600 hover:bg-white transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-900">
                                        {{ $a->placa ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $a->marca ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $a->clase ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">
                                        {{ $a->compra ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">
                                        {{ $a->fabricacion ?? '---' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-lg bg-ig-dark/5 px-2.5 py-1 text-[11px] font-bold text-ig-dark ring-1 ring-ig-dark/10">
                                            {{ $a->tipo_propiedad ?? '---' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <p class="text-sm text-slate-500 font-medium">No se encontraron vehículos registrados.</p>
            </div>
        @endif
    </div>
</details>
@props(['situacion'])

<section class="space-y-6">
    @if($situacion)
        {{-- HEADER + FECHA --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-800">Situación Financiera</h3>
                <p class="mt-1 text-sm text-slate-500 font-medium">
                    Resumen de calificaciones SBS y detalle por entidad bancaria.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 shadow-sm">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div class="leading-tight">
                    <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Fecha Reporte</div>
                    <div class="text-sm font-bold text-slate-700">{{ $situacion->fecha_reporte ?? '---' }}</div>
                </div>
            </div>
        </div>

        {{-- RESUMEN (BARRAS DE PROGRESO) --}}
        @php
            $calificaciones = [
                ['label' => 'Normal',     'val' => $situacion->calificacion_normal,    'color' => 'bg-emerald-500', 'p' => $situacion->porcentaje_normal],
                ['label' => 'CPP',        'val' => $situacion->calificacion_cpp,       'color' => 'bg-teal-400',    'p' => $situacion->porcentaje_potencial],
                ['label' => 'Deficiente', 'val' => $situacion->calificacion_deficiente, 'color' => 'bg-amber-400',   'p' => $situacion->porcentaje_deficiente],
                ['label' => 'Dudoso',     'val' => $situacion->calificacion_dudoso,     'color' => 'bg-orange-500',  'p' => $situacion->porcentaje_dudoso],
                ['label' => 'Pérdida',    'val' => $situacion->calificacion_perdida,    'color' => 'bg-rose-500',    'p' => $situacion->porcentaje_perdida],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach($calificaciones as $cal)
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm group hover:border-ig-dark/20 transition-all">
                    <div class="flex items-center justify-between gap-3 mb-3">
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-tight">{{ $cal['label'] }}</div>
                        <div class="text-sm font-black text-slate-800">{{ number_format($cal['p'], 2) }}%</div>
                    </div>
                    <div class="h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full {{ $cal['color'] }} transition-all duration-1000" style="width: {{ $cal['p'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- DETALLE (TABLA) --}}
        <div class="rounded-3xl border border-slate-200 bg-white overflow-hidden shadow-sm">
            <div class="flex items-center justify-between gap-3 px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <div class="text-sm font-bold text-slate-800">Detalle por Entidad</div>
                    <div class="mt-0.5 text-[11px] text-slate-400 font-medium font-medium">Análisis individual de montos y morosidad.</div>
                </div>

                @if($situacion->detalles)
                    <div class="inline-flex items-center rounded-lg bg-white px-2.5 py-1 text-[10px] font-bold text-slate-500 ring-1 ring-slate-200 shadow-sm">
                        {{ count($situacion->detalles) }} Entidad(es)
                    </div>
                @endif
            </div>

            @if($situacion->detalles && count($situacion->detalles) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] uppercase tracking-widest text-slate-400 border-b border-slate-100">
                                <th class="px-5 py-3 font-bold w-16 text-center">Nro</th>
                                <th class="px-5 py-3 font-bold">Entidad Financiera</th>
                                <th class="px-5 py-3 font-bold">Monto Total</th>
                                <th class="px-5 py-3 font-bold">Días de Atraso</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($situacion->detalles as $s)
                                <tr class="text-sm text-slate-600 hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-5 py-4 text-slate-400 text-center font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4 font-bold text-slate-800 group-hover:text-ig-dark transition-colors">
                                        {{ $s->entidad ?? '---' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1 text-[12px] font-bold text-slate-700 ring-1 ring-slate-200">
                                            S/ {{ number_format($s->monto ?? 0, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold {{ ($s->dias_atraso ?? 0) > 0 ? 'text-rose-500' : 'text-emerald-500' }}">
                                                {{ $s->dias_atraso ?? '0' }}
                                            </span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">días</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 py-10 text-center text-sm text-slate-400 font-medium">
                    Sin detalles financieros disponibles para este periodo.
                </div>
            @endif
        </div>

    @else
        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-200 text-slate-400 mb-3">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm text-slate-500 font-bold">No se encontró información financiera registrada en SBS.</p>
        </div>
    @endif
</section>
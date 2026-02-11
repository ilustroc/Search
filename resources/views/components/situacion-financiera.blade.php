@props(['situacion'])
<section>
    @if($situacion)
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h3 class="text-lg sm:text-xl font-semibold text-white/90">Situación financiera</h3>
                <p class="mt-1 text-sm text-white/55">Resumen de calificaciones y detalle por entidad.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-black/20 px-4 py-2">
                <div class="text-sm font-semibold text-white/90">{{ $situacion->fecha_reporte ?? '---' }}</div>
            </div>
        </div>

        @php
            $calificaciones = [
                ['label' => 'Normal', 'val' => $situacion->calificacion_normal, 'color' => 'bg-emerald-400/80'],
                ['label' => 'CPP', 'val' => $situacion->calificacion_cpp, 'color' => 'bg-teal-300/80'],
                ['label' => 'Deficiente', 'val' => $situacion->calificacion_deficiente, 'color' => 'bg-amber-300/80'],
                ['label' => 'Dudoso', 'val' => $situacion->calificacion_dudoso, 'color' => 'bg-orange-300/80'],
                ['label' => 'Pérdida', 'val' => $situacion->calificacion_perdida, 'color' => 'bg-rose-300/80'],
            ];
        @endphp

        <div class="mt-5 grid grid-cols-1 md:grid-cols-5 gap-3">
            @foreach($calificaciones as $cal)
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-semibold text-white/85">{{ $cal['label'] }}</div>
                        <div class="text-sm font-bold text-white">{{ number_format($cal['val'] ?? 0, 2) }}%</div>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-white/10 overflow-hidden">
                        <div class="h-full rounded-full {{ $cal['color'] }}" style="width: {{ $cal['val'] ?? 0 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 rounded-3xl border border-white/10 bg-black/20 overflow-hidden">
            <table class="min-w-full text-left">
                <thead class="bg-white/5">
                    <tr class="text-[11px] uppercase tracking-widest text-white/55">
                        <th class="px-5 py-3">Entidad</th>
                        <th class="px-5 py-3">Monto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach($situacion->detalles as $s)
                    <tr class="text-sm text-white/80 hover:bg-white/5 transition">
                        <td class="px-5 py-3 font-semibold text-white/90">{{ $s->entidad ?? '---' }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center rounded-xl border border-white/10 bg-white/5 px-2.5 py-1 text-[12px] font-semibold text-white/85">
                                S/ {{ number_format($s->monto ?? 0, 2) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="rounded-3xl border border-white/10 bg-black/20 px-5 py-6 text-sm text-white/60">No se encontró información financiera.</div>
    @endif
</section>
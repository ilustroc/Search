@props(['telefonos', 'cliente', 'osiptel_verificados' => []])

<details class="group rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden" open>
    <summary class="list-none cursor-pointer select-none px-5 py-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 border border-slate-200 text-slate-500">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 11.2 19a19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.6a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.5-1.2a2 2 0 0 1 2.1-.5c.8.3 1.7.5 2.6.6A2 2 0 0 1 22 16.9Z"/>
                </svg>
            </span>
            <div class="leading-tight">
                <div class="text-sm font-bold text-slate-800">Teléfonos</div>
                <div class="text-[11px] font-medium text-slate-400">{{ count($telefonos) }} registro(s) detectado(s)</div>
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
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Titularidad</th>
                                <th class="px-4 py-3 text-left font-bold uppercase tracking-wider text-[10px]">Tipo</th>
                                <th class="px-4 py-3 text-center font-bold uppercase tracking-wider text-[10px]">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($telefonos as $tel)
                                <tr class="text-slate-600 hover:bg-white transition-colors" 
                                    data-phone="{{ $tel->telefono }}" 
                                    data-dni="{{ $cliente->documento }}"> {{-- Aquí ya no dará error --}}
                                    <td class="px-4 py-3 font-bold text-slate-900">
                                        {{ $tel->telefono }}
                                    </td>
                                    <td class="px-4 py-3 uppercase text-[11px] font-semibold">
                                        <span class="operador-text">{{ $tel->origen ?? '---' }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="status-osiptel flex items-center gap-1.5 text-[10px] text-slate-400 font-medium">
                                            <svg class="animate-spin h-3 w-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            Validando...
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-lg bg-slate-200/50 px-2 py-0.5 text-[10px] font-bold text-slate-600 ring-1 ring-slate-200 uppercase type-badge">
                                            {{ $tel->tipo ?? '---' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="https://wa.me/51{{ $tel->telefono }}?text=Hola,%20nos%20comunicamos%20de%20KP%20Invest." 
                                               target="_blank" 
                                               class="whatsapp-btn inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-100 text-slate-400 opacity-50 cursor-wait shadow-sm transition-all">
                                                <span class="status-dots text-[10px]">. . .</span>
                                                <svg class="whatsapp-icon h-4 w-4 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            </a>
                                            <a href="https://messages.google.com/web/authentication?launch=true&number=51{{ $tel->telefono }}" target="_blank" class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                            </a>
                                        </div>
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
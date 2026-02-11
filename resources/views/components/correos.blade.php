@props(['correos'])
<div>
    <div class="flex items-start justify-between gap-3">
        <div>
            <h4 class="text-xs font-semibold tracking-widest text-white/70 uppercase">Correos electrónicos</h4>
            <p class="mt-1 text-[12px] text-white/45">Canales de contacto registrados.</p>
        </div>
    </div>

    @if($correos && count($correos) > 0)
        <div class="mt-4 rounded-2xl border border-white/10 bg-black/20 overflow-hidden">
            <ul class="divide-y divide-white/10">
                @foreach($correos as $correo)
                    <li class="px-4 py-3 text-sm text-white/85 hover:bg-white/5 transition">
                        {{ $correo->correo }}
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="mt-4 rounded-2xl border border-white/10 bg-black/20 px-4 py-4 text-sm text-white/65">
            No se encontraron correos registrados.
        </div>
    @endif
</div>
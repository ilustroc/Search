<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta Cliente - IMPULSE GO</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-b from-[#0B0614] via-[#140A2A] to-[#090515] text-white">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">

            <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl shadow-2xl p-7 sm:p-8">
                <div class="flex justify-center">
                    <img src="{{ asset(path: 'img/logo.png') }}"
                         alt="IMPULSE GO"
                         class="h-12 w-auto drop-shadow"/>
                </div>

                <div class="text-center mt-5">
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Consulta de Clientes  
                    </h1>
                    <p class="mt-2 text-sm text-white/70">
                        Consulta rápida por Documento (DNI) o RUC.
                    </p>
                </div>

                <div class="mt-6">
                    <div class="grid grid-cols-2 rounded-2xl bg-white/5 p-1 border border-white/10">
                        <button
                            type="button" id="tab-dni" data-tipo="DNI"
                            class="tab-btn rounded-xl px-4 py-2 text-sm font-semibold transition select-none text-white/80 hover:text-white">
                            Por DNI
                        </button>

                        <button type="button" id="tab-ruc" data-tipo="RUC"
                            class="tab-btn rounded-xl px-4 py-2 text-sm font-semibold transition select-none text-white/80 hover:text-white">
                            Por RUC
                        </button>
                    </div>

                    <p id="helper" class="mt-3 text-xs text-white/60">
                        Ingresa un DNI de 8 dígitos.
                    </p>
                </div>

                <form id="form-buscar" method="POST" action="{{ route('buscar') }}" autocomplete="off" class="mt-4 space-y-4">
                    @csrf
                    
                    <input type="hidden" name="tipo" id="tipo-input" value="DNI" />

                    <div>
                        <label id="label-busqueda" class="block text-sm font-medium text-white/80">
                            Documento (DNI)
                        </label>

                        <div class="mt-2 relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-white/40" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                          stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </div>

                            <input
                                id="busqueda-input"
                                name="documento"
                                type="text"
                                inputmode="numeric"
                                placeholder="Ej: 12345678"
                                maxlength="8"
                                class="w-full rounded-2xl border border-white/10 bg-white/5 pl-10 pr-3 py-3 text-sm outline-none
                                       text-white placeholder:text-white/35
                                       focus:border-[#4C1D95] focus:ring-4 focus:ring-[#4C1D95]/20 transition"
                                required/>
                        </div>

                        @if($errors->any())
                        <div id="error-box" class="mt-3 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                            <span id="error-msg">{{ $errors->first() }}</span>
                        </div>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="mt-2 w-full rounded-2xl bg-[#4C1D95] text-white py-3 font-semibold shadow-lg
                               hover:bg-[#3B1383] active:bg-[#2E1065] transition">
                        Buscar
                    </button>

                    <div class="pt-2 text-center text-[11px] text-white/45">
                        Uso interno · No compartas información sensible.
                    </div>
                </form>
            </div>

            <div class="mt-6 text-center text-xs text-white/35">
                IMPULSE GO · Consulta
            </div>
        </div>
    </div>
</body>
</html>
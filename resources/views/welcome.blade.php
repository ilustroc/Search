<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Consulta Cliente - IMPULSE GO</title>

    @vite(['resources/css/app.css', 'resources/js/search-form.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC] text-slate-900 font-sans">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-7 sm:p-10">
                
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('img/logo.png') }}"
                         alt="IMPULSE GO"
                         class="h-14 w-auto object-contain"/>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight">
                        Consulta de Clientes  
                    </h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Busca rápidamente por DNI o RUC en nuestra base de datos.
                    </p>
                </div>

                <div class="mb-6">
                    <div class="grid grid-cols-2 rounded-2xl bg-slate-100 p-1.5">
                        <button
                            type="button" id="tab-dni" data-tipo="DNI"
                            class="tab-btn rounded-xl px-4 py-2.5 text-sm font-bold transition-all select-none">
                            Por DNI
                        </button>

                        <button type="button" id="tab-ruc" data-tipo="RUC"
                            class="tab-btn rounded-xl px-4 py-2.5 text-sm font-bold transition-all select-none">
                            Por RUC
                        </button>
                    </div>

                    <p id="helper" class="mt-3 text-center text-xs text-slate-400 font-medium">
                        Ingresa un DNI válido de 8 dígitos.
                    </p>
                </div>

                <form id="form-buscar" method="POST" action="{{ route('buscar') }}" autocomplete="off" class="space-y-5">
                    @csrf
                    <input type="hidden" name="tipo" id="tipo-input" value="DNI" />

                    <div>
                        <label id="label-busqueda" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">
                            Número de Documento
                        </label>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#4C1D95] transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round"/>
                                    <circle cx="12" cy="7" r="4" stroke-width="2"/>
                                </svg>
                            </div>

                            <input
                                id="busqueda-input"
                                name="documento"
                                type="text"
                                inputmode="numeric"
                                placeholder="Ej: 12345678"
                                maxlength="8"
                                class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 pl-11 pr-4 py-3.5 text-slate-700 font-medium outline-none
                                       focus:border-[#4C1D95]/30 focus:bg-white focus:ring-4 focus:ring-[#4C1D95]/5 transition-all"
                                required/>
                        </div>

                        @if($errors->any())
                        <div id="error-box" class="mt-4 rounded-xl bg-red-50 border border-red-100 px-4 py-3 text-xs text-red-600 font-medium animate-pulse">
                            <span id="error-msg">⚠️ {{ $errors->first() }}</span>
                        </div>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-[#4C1D95] text-white py-4 font-bold shadow-lg shadow-purple-200
                               hover:bg-[#3B1383] hover:shadow-purple-300 active:transform active:scale-[0.98] transition-all">
                        Consultar
                    </button>

                    <div class="pt-2 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        Sistema de Uso Interno
                    </div>
                </form>
            </div>

            <div class="mt-8 text-center">
                <p class="text-xs text-slate-400 font-medium">
                    &copy; {{ date('Y') }} IMPULSE GO &middot; Terminal de Consulta
                </p>
            </div>
        </div>
    </div>
</body>
</html>
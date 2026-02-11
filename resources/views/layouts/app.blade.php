<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'IMPULSE GO')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="min-h-screen bg-[#F8FAFC] text-slate-900 font-sans">

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/80 backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between gap-8">

                <div class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-8 w-auto" />
                    <div class="hidden md:block border-l border-slate-200 pl-3">
                        <div class="text-sm font-bold tracking-tight text-slate-800">IMPULSE GO</div>
                        <div class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Data Center</div>
                    </div>
                </div>

                <div class="flex-1 max-w-md hidden sm:block">
                    <form action="{{ route('buscar') }}" method="POST" class="relative group">
                        @csrf
                        <input type="hidden" name="tipo" value="DNI">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-focus-within:text-[#4C1D95] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="documento" 
                            class="search-input-header" 
                            placeholder="Consultar otro DNI...">
                    </form>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.import.index') }}" class="p-2 text-slate-400 hover:text-ig-dark hover:bg-slate-100 rounded-xl transition-all" title="Admin">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <a href="{{ url('/') }}" class="p-2 text-slate-400 hover:text-ig-dark hover:bg-slate-100 rounded-xl transition-all">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- ÁREA DE NOTIFICACIONES Y ERRORES DE LOGS --}}
        <div class="space-y-4 mb-6">
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 font-bold text-sm flex items-center gap-3">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100 text-blue-700 font-bold text-sm flex items-center gap-3">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('info') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700 font-bold text-sm flex items-center gap-3">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- DETALLE TÉCNICO DE ERRORES EN CSV (LOGS) --}}
            @if (session()->has('import_errors'))
                <div class="bg-rose-50 border border-rose-200 rounded-2xl overflow-hidden">
                    <div class="px-4 py-3 bg-rose-100/50 border-b border-rose-200">
                        <h4 class="text-rose-800 font-bold text-sm uppercase tracking-wider">Errores de Validación en el Archivo</h4>
                    </div>
                    <div class="p-4 max-h-60 overflow-y-auto">
                        <ul class="text-xs text-rose-600 space-y-2">
                            @foreach (session()->get('import_errors') as $failure)
                                <li class="flex gap-2">
                                    <span class="font-bold shrink-0">[Fila {{ $failure->row() }}]</span>
                                    <span>{{ implode(', ', $failure->errors()) }} (Dato: <span class="font-mono bg-rose-200/50 px-1 rounded">{{ $failure->values()[$failure->attribute()] ?? 'N/A' }}</span>)</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <footer class="py-12 border-t border-slate-200 bg-white">
        <div class="text-center">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                &copy; {{ date('Y') }} IMPULSE GO &middot; Terminal de Consulta Interna
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
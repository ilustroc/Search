<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'IMPULSE GO')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>

<body class="min-h-screen bg-gradient-to-b from-[#0B0614] via-[#140A2A] to-[#090515] text-white">

    <header class="sticky top-0 z-50 border-b border-white/10 bg-black/20 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between gap-4">

                <div class="flex items-center gap-3 min-w-0">
                    <img src="{{ asset('img/logo.png') }}"
                         alt="IMPULSE GO"
                         class="h-9 w-auto opacity-90" />

                    <div class="min-w-0">
                        <div class="text-sm font-semibold tracking-wide text-white/90 truncate">IMPULSE GO</div>
                        <div class="text-xs text-white/60 truncate">Consulta de Clientes</div>
                    </div>
                </div>

                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold
                          text-white/90 shadow-sm hover:bg-white/10 active:bg-white/15 transition">
                    <svg class="h-5 w-5 text-white/80" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1v-9.5Z"
                              stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                    <span>Inicio</span>
                </a>

            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')

        <footer class="mt-8 text-center text-xs text-white/35">
            IMPULSE GO · Uso interno
        </footer>
    </main>

    @stack('scripts')
</body>
</html>
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                // Global/Layout
                'resources/css/app.css',
                'resources/css/layout.css', // Añadido porque existe en tu carpeta
                'resources/js/app.js',

                // Específico para el Inicio (Welcome)
                // Eliminado welcome.css porque no existe físicamente
                'resources/js/search-form.js',

                // Específico para el Resultado del Cliente
                'resources/css/resultado.css',
                'resources/js/resultado.js',
                
                // Otros archivos JS que se ven en tu captura
                'resources/js/tabs.js',
                'resources/js/ui.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
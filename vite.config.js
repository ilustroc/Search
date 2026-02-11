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
                'resources/js/app.js',

                // Específico para el Inicio (Welcome)
                'resources/css/welcome.css',
                'resources/js/search-form.js',

                // Específico para el Resultado del Cliente
                'resources/css/resultado.css',
                'resources/js/resultado.js',
                
                // Si llegaras a tener otros módulos
                // 'resources/css/admin.css',
                // 'resources/js/admin.js',
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

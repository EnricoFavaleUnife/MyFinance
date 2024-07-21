import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/custom.css'],
            refresh: true,
        }),
    ],
    server: {
        proxy: {
            '^/(?!resources/|css/|js/|img/|favicon.ico)': {
                target: 'http://localhost:8000',
                changeOrigin: true,
                secure: false,
            },
        },
    },
});

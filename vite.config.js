import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/auth.css',
                'resources/css/notify.css',
                'resources/css/style.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/notify.js',
                'resources/js/script.js',
                'resources/js/theme.js',
            ],
            refresh: true,
        }),
    ],
});

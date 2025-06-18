import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'public/assets/fonts/fleetmarket.v1.1/styles.css'
            ],
            refresh: true,
        })
    ],
});

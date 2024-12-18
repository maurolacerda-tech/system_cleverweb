import { defineConfig } from 'vite';
import path from 'path';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/panel/sass/auth.scss',
                'resources/panel/sass/app.scss',
                'resources/panel/js/app.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, 'node_modules/bootstrap'),
            '~select2': path.resolve(__dirname, 'node_modules/select2'),
            '~shadowbox': path.resolve(__dirname, 'node_modules/shadowbox-js')
        }
    },
    css: {
        preprocessorOptions: {
          scss: {
            api: 'modern-compiler',
          },
        },
    },
});

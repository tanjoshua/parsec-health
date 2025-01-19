import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from "@sveltejs/vite-plugin-svelte";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/fonts.css',
                'resources/css/app.css',
                'resources/js/app.ts'
            ],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        svelte({
            compilerOptions: {
                hmr: { preserve: true },
            },
            hot: {
                preserveLocalState: true,
                fullReload: false
            }
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js'
        }
    },
    optimizeDeps: {
        include: ['svelte']
    }
});

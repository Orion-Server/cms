import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import Path from 'path'

export default defineConfig({
    build: {
        outDir: Path.join(__dirname, 'public', 'build'),
        emptyOutDir: true,
    },
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', 'resources/css/filament.css'],
            refresh: true,
            transformOnServe: (code) => code.replaceAll('/assets/', '/public/assets/'),
        }),
    ],
    resolve: {
        alias: {
            '@public': '/public',
            '@packages': '/node_modules'
        }
    }
})

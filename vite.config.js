import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import Path from 'path'

export default defineConfig({
    build: {
        outDir: Path.join(__dirname, 'public', 'build'),
        emptyOutDir: true,
    },
    server: {
        host: 'localhost'
    },
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js', 'resources/js/client.js'],
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

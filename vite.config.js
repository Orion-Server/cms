import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import Path from 'path'

export default defineConfig({
    server: {

    },
    build: {
        outDir: Path.join(__dirname, 'public', 'build'),
        emptyOutDir: true
    },
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@public': '/public',
            '@packages': '/node_modules'
        }
    }
})

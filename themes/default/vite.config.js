import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    build: {
        outDir: path.join(__dirname, '..', '..', 'public', 'build'),
        emptyOutDir: true,
    },
    plugins: [
        laravel({
            input: [
                "themes/default/css/app.css",
                "themes/default/js/app.js"
            ],
            buildDirectory: "default",
            transformOnServe: (code) => code.replaceAll('/assets/', '/public/assets/'),
        }),
    ],
    resolve: {
        alias: {
            '@': '/themes/default/js',
            '@public': '/public',
            '@packages': '/node_modules'
        }
    },
    css: {
        postcss: {
            plugins: [
                require("tailwindcss")({
                    config: path.resolve(__dirname, "tailwind.config.js"),
                }),
            ],
        },
    },
});

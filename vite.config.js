import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";



import path from "path"; // Adicionando a importação do 'path'
export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/css/ti.css",
            ],
            refresh: true,
        }),
    ],

    server: {
        host:  "0.0.0.0", // Usa a variável de ambiente ou um valor padrão
        port:5173, // Porta configurável
        strictPort: true,
        cors: true,
        hmr: {
            host:  "localhost", // Configurável via variável de ambiente
            port:  5173,
        },
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
});
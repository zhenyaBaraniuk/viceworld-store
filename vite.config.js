import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import inertia from "@inertiajs/vite";
import react from "@vitejs/plugin-react";
import { fileURLToPath, URL } from "node:url";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
        inertia(),
        tailwindcss(),
    ],
    server: {
        host: "127.0.0.1",
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("resources/js", import.meta.url)),
            "@css": fileURLToPath(new URL("resources/css", import.meta.url)),
        },
    },
});

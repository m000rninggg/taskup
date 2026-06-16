import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/dashboard.css',
                'resources/css/tasks.css',
                'resources/css/project.css',
                'resources/css/project-settings.css',
                'resources/css/project-shell.css',
                'resources/css/documentation.css',
                'resources/css/login.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});

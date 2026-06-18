import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home.css',
                'resources/css/workspace.css',
                'resources/css/dashboard.css',
                'resources/css/directory.css',
                'resources/css/profile.css',
                'resources/css/tasks.css',
                'resources/css/task-comments.css',
                'resources/css/task-modals.css',
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

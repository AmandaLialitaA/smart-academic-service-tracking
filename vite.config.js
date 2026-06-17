import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dashboard-mahasiswa.css',
                'resources/css/dashboard-dosen.css',
                'resources/css/dashboard-admin.css',
                'resources/css/pengajuan.css',
                'resources/css/tracking.css',
                'resources/css/detail-pengajuan-dosen.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
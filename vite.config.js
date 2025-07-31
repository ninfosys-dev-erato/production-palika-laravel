import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/upload-helper.js',
                'resources/js/customer-kyc-upload.js'
            ],
            refresh: true,
        }),
    ],
});


import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx'],  // Make sure your main JSX entry file is correctly specified
            refresh: true,  // Ensures that file changes trigger a page refresh
        }),
        react({
            // Enable Fast Refresh for React
            fastRefresh: true,  // Ensure Fast Refresh is enabled
        }),
    ],
});





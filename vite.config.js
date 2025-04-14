import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
  build: {
    outDir: 'public/build',
    manifest: 'mix-manifest.json',
  },
  server: {
    host: '127.0.0.1', // or 'localhost'
    port: 5173,
    proxy: {
      '/api': {
        target: 'http://127.0.0.1:8000', // Proxy API requests to the Laravel backend
        changeOrigin: true, // Changes the origin of the host header to the target URL
        secure: false, // Allows insecure requests (useful for development with HTTP)
        // Add rewrite to remove '/api' prefix
        rewrite: (path) => path.replace(/^\/api/, '')
      },
    },
  },
});
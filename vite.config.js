import { defineConfig } from 'vite';

export default defineConfig({
  base: '',
  publicDir: 'assets/static',
  build: {
    manifest: true,
    assetsDir: '',
    outDir: `dist`,
    emptyOutDir: true,
    sourcemap: true,
    rollupOptions: {
      input: [
        'assets/js/main.js',
        'assets/sass/main.scss',
      ],
      output: {
        entryFileNames: '[hash].js',
        assetFileNames: '[hash].[ext]',
      },
    },
  },
  server: {
    origin: 'http://localhost:5173',
    clientPort: 5173,
  },
  plugins: [
    {
      name: 'php',
      handleHotUpdate({ file, server }) {
        if (file.endsWith('.php')) {
          server.ws.send({ type: 'full-reload' });
        }
      },
    },
  ],
  css: {
    preprocessorOptions: {
      scss: {
        api: 'modern-compiler',
      }
    }
  }
});
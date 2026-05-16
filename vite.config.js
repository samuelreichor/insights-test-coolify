import path from 'node:path';
import mkcert from 'vite-plugin-mkcert';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import tailwindcss from '@tailwindcss/vite'
import ViteRestart from 'vite-plugin-restart';

export default ({command}) => ({
  base: command === 'serve' ? '' : '/dist/',
  publicDir: './assets/public',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: './web/dist',
    rollupOptions: {
      input: {
        app: './assets/js/app.ts',
      },
    },
    sourcemap: true,
  },
  plugins: [
    nodeResolve({
      modulePaths: [path.resolve('./node_modules')],
    }),
    mkcert(),
    tailwindcss(),
    ViteRestart({
      restart: ['./templates/**/*.{twig,html,json,php}'],
    }),
  ],
  server: {
    fs: {
      strict: false,
    },
    host: '0.0.0.0',
    https: true,
    origin: 'https://localhost:3000',
    port: 3000,
    strictPort: true,
    cors: {
      origin: /https?:\/\/([A-Za-z0-9\-.]+)?(\.ddev\.site)(?::\d+)?$/,
    },
  },
});

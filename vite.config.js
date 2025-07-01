import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src')
    }
  },
  server: {
    proxy: {
      '/web/session/authenticate': {
        target: 'http://localhost:8069',
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/api/, '') // opsional
      },
      '/web/dataset/call_kw': {
        target: 'http://localhost:8069',
        changeOrigin: true,
        secure: false,
        rewrite: (path) => path.replace(/^\/api/, '')
      },
      '/web': {
        target: 'http://localhost:8069',
        changeOrigin: true,
        secure: false,
        ws: true
      }
    }
  }
})
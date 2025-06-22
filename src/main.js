import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import App from './App.vue'
import router from './router'
import store from './store' // 🔥 Import store

createApp(App).use(router).use(store).mount('#app') // 🔥 Tambahkan .use(store)
import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import App from './App.vue'
import router from './router'
import store from './store' // 🔥 Import store
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

const app = createApp(App);

app
  .use(ElementPlus) // 🔥 Tambahkan ElementPlus
  .use(router)
  .use(store)
  .mount('#app'); // 🔥 Tambahkan .use(store)
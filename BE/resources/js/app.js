// resources/js/app.js

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => import(`./Pages/${name}.vue`),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        app.use(plugin)

        // // ⬇ Muat ziggy.js secara manual
        // const script = document.createElement('script')
        // script.src = './ziggy.js'
        // script.onload = () => {
        //     console.log('ziggy.js berhasil dimuat')
        // }
        // script.onerror = () => {
        //     console.error('Gagal memuat ziggy.js')
        // }
        // document.head.appendChild(script)

        // console.info("script ", script);

        app.mount(el)
        return app
    },
})

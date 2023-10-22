import { createApp } from 'vue'

import App from './App.vue'
import router from './router'
import register from './assets/register.css'

const app = createApp(App)

app.use(router)

app.mount('#app')

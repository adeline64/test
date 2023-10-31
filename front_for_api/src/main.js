import { createApp } from 'vue'

import App from './App.vue'
import router from './router'
import home from './assets/home.css'
import product from './assets/product.css'

const app = createApp(App)

app.use(router)

app.use(home)

app.use(product)

app.mount('#app')

import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import './index.css'
import HomeView from './views/MainPage.vue'

const router = createRouter({
  routes: [
    {
      path: '/',
      component: HomeView
    }
  ],
  history: createWebHistory()
})

const app = createApp(App)

app.use(router)
app.mount('#app')

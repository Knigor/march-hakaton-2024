import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import './index.css'
import AuthPage from './views/AuthPage.vue'
import RegistrationPage from './views/RegistrationPage.vue'
import MainPage from './views/MainPage.vue'

const router = createRouter({
  routes: [
    {
      path: '/',
      component: AuthPage
    },
    {
      path: '/registration',
      component: RegistrationPage
    },
    {
      path: '/MainPage',
      component: MainPage
    },
    {}
  ],
  history: createWebHistory()
})

const app = createApp(App)

app.use(router)
app.mount('#app')

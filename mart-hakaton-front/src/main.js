import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import './index.css'
import AuthPage from './views/AuthPage.vue'
import RegistrationPage from './views/RegistrationPage.vue'
import MainPage from './views/MainPage.vue'
import TeacherAddMaterialsPage from './views/TeacherAddMaterialsPage.vue'
import TeacherAddsubject from './views/TeacherAddSubject.vue'
import StudentDiscipline from './views/StudentDisciplinePage.vue'
import StudentMaterials from './views/StudentMaterials.vue'

const router = createRouter({
  routes: [
    {
      path: '/',
      name: 'AuthPage',
      component: AuthPage
    },
    {
      path: '/registration',
      name: 'RegistrationPage',
      component: RegistrationPage
    },
    {
      path: '/MainPage',
      component: MainPage
    },
    {
      path: '/addMaterial',
      component: TeacherAddMaterialsPage
    },
    {
      path: '/addSubject',
      component: TeacherAddsubject
    },
    {
      path: '/materials',
      component: StudentMaterials
    },
    {
      path: '/discipline',
      component: StudentDiscipline
    }
  ],
  history: createWebHistory()
})

const app = createApp(App)

app.use(router)
app.mount('#app')

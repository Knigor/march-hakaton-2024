<template>
  <div class="h-full w-full flex justify-center p-16">
    <div class="flex flex-col h-full w-1/3 gap-16 justify-center items-center">
      <SiteLogo :isVertical="true" />
      <div class="bg-blue-200 h-px mt-8 w-full"></div>
      <!-- Форма входа -->
      <div class="flex flex-col items-center gap-12 w-[75%]">
        <h2 class="font-semibold text-3xl">Вход</h2>
        <div class="flex flex-col gap-5 w-full">
          <Input placeholder="Ваш логин" v-model="login" />
          <Input type="password" placeholder="Пароль" v-model="password" />
        </div>
        <div class="flex flex-col gap-2 w-full">
          <Alert v-if="isVisible" class="mt-5" variant="destructive">
            <AlertTitle>Ошибка</AlertTitle>
            <AlertDescription>Неверно введен логин или пароль!</AlertDescription>
          </Alert>
          <div class="flex flex-col gap-2">
            <div class="flex flex-row sm:max-lg:flex-col gap-2">
              <Button @click="saveData" class="w-full">Войти</Button>
              <Button @click="authorizeVK" class="w-fit bg-blue-500 sm:max-lg:w-full">
                <img class="w-4 h-4 mr-1" src="../img/vk-logo.svg" />Через VK ID
              </Button>
            </div>
            <Button @click="redirectToRegisterPage" variant="ghost" class="w-full"
              >Регистрация</Button
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'

import SiteLogo from '../components/custom/SiteLogo.vue'
import axios from 'axios'

const router = useRouter()

const login = ref('')
const password = ref('')
const isVisible = ref(false)

const authorizeVK = () => {
  const clientId = '51877729' // ID приложения VK
  const redirectUri = 'http://localhost/vk.php' // Адрес перенаправления (адрес вашего Vue приложения)

  // Формируем URL для авторизации VK
  const authUrl = `https://oauth.vk.com/authorize?client_id=${clientId}&display=page&redirect_uri=${redirectUri}&scope=photos&response_type=code&v=5.131`

  // Перенаправляем пользователя на страницу авторизации VK
  window.location.href = authUrl
}

const redirectToRegisterPage = () => {
  router.push({ name: 'RegistrationPage' })
}

async function saveData() {
  const params = new URLSearchParams()
  params.append('username', login.value)
  params.append('password', password.value)

  try {
    const response = await axios.post('http://localhost/login.php', params, {
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
    const status = response.data.status
    console.log('Ответ от сервера:', status)

    console.log(response.data.id_user)

    if (status === 'success') {
      localStorage.setItem('login', login.value)
      localStorage.setItem('id_user', response.data.id_user)
      localStorage.setItem('role_user', response.data.role)
      localStorage.setItem('full_name', response.data.full_name)

      console.log(localStorage.getItem('login'))

      // Переход на страницу MainPage
      router.push({ name: 'MainPage' })
    } else {
      isVisible.value = true
    }

    isVisible.value = status === 'error'
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}
</script>

<style></style>

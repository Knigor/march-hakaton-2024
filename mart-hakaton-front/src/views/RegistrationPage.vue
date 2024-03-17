<template>
  <div class="h-full w-full flex justify-center p-16">
    <div class="flex flex-col h-full w-1/3 gap-16 justify-center items-center">
      <SiteLogo isVertical />
      <div class="bg-blue-200 h-px mt-8 w-full"></div>
      <!-- Форма входа -->
      <div class="flex flex-col items-center gap-12 w-[75%]">
        <h2 class="font-semibold text-3xl">Регистрация</h2>
        <div class="flex flex-col gap-5 w-full">
          <Input v-model="FullName" placeholder="ФИО" />
          <Input v-model="BirthDate" placeholder="Дата рождения" />
          <Input v-model="Login" placeholder="Придумайте логин" />
          <Input v-model="Password" type="password" placeholder="Придумайте пароль" />
          <RadioGroup class="flex sm:max-lg:flex-col justify-between w-full" v-model="selectedRole">
            <div class="flex items-center space-x-2">
              <RadioGroupItem id="student" value="student" />
              <Label for="student">Я студент</Label>
            </div>
            <div class="flex items-center space-x-2">
              <RadioGroupItem id="teacher" value="teacher" />
              <Label for="teacher">Я преподаватель</Label>
            </div>
          </RadioGroup>
          <Alert v-if="isVisible" class="mt-5" variant="destructive">
            <AlertTitle>Ошибка</AlertTitle>
            <AlertDescription class="w-80"
              >Пользователь с таким логином уже существует или заполнены не все
              поля</AlertDescription
            >
          </Alert>
        </div>
        <div class="flex flex-col gap-2 w-full">
          <Alert v-if="isVisible" class="mt-5" variant="destructive">
            <AlertTitle>Ошибка</AlertTitle>
            <AlertDescription>Неверно введен логин или пароль!</AlertDescription>
          </Alert>
          <div class="flex flex-col gap-2">
            <div class="flex flex-row sm:max-lg:flex-col gap-2">
              <Button @click="saveData" class="w-full">Зарегистрироваться</Button>
              <Button class="w-fit bg-blue-500 sm:max-xl:w-full"
                ><img class="w-4 h-4 mr-1" src="../img/vk-logo.svg" />Через VK ID</Button
              >
            </div>
            <Button @click="redirectToRegisterPage" variant="ghost" class="w-full">Войти</Button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { useStore } from 'vuex'
import SiteLogo from '../components/custom/SiteLogo.vue'

import axios from 'axios'

const router = useRouter()

const store = useStore()

const FullName = ref('')
const BirthDate = ref('')
const Login = ref('')
const Password = ref('')
const selectedRole = ref('student')
const register = ref('register')
const isVisible = ref(false)

const handleUserTypeChange = (value) => {
  userType.value = value
}

// const watchUserTypeChange = (newValue) => {
//   console.log('Выбран тип пользователя:', newValue)
// }

const redirectToAuthPage = () => {
  router.push({ name: 'AuthPage' })
}

const redirectToMainPage = () => {
  router.push({ name: 'MainPage' })
}

async function saveData(newValue) {
  // if (!FullName.value || !BirthDate.value || !Login.value || !Password.value) {
  //   alert('Пожалуйста, заполните все поля!')
  //   return
  // }

  const params = new URLSearchParams()
  params.append('login', Login.value)
  params.append('full_name', FullName.value)
  params.append('password', Password.value)
  params.append('date_birth', BirthDate.value)
  params.append('role', selectedRole.value)
  params.append('register', register.value)

  try {
    const response = await axios.post('http://localhost/registration.php', params, {
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
    console.log('Ответ от сервера:', response) // Выводим весь ответ сервера
    const status = response.data.status
    console.log('Статус ответа:', status)

    console.log(response.data.user)

    // Это локальное хранилище для пользователя

    if (status === 'success') {
      localStorage.setItem('login', response.data.user.login)
      localStorage.setItem('role_user', response.data.user.role_user)
      localStorage.setItem('id_user', response.data.user.id_user)
      localStorage.setItem('full_name', response.data.user.full_name_user)

      console.log(localStorage.getItem('login'))

      redirectToMainPage()
    } else {
      // Если статус ответа не 'success', устанавливаем isVisible в true
      isVisible.value = true
    }
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap');
.text-extra-bold {
  font-family: 'Inter', sans-serif;
  font-size: 32px;
}

.text-inter-semi-bold {
  font-family: 'Inter', sans-serif;
  font-weight: 600; /* Semi-Bold вес шрифта */
  font-size: 28px;
}
</style>

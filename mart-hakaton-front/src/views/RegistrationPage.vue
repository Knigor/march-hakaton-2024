<template>
  <div class="h-full flex flex-col justify-center gap-10">
    <div class="flex flex-row justify-center gap-5">
      <div class="px-10 py-25">
        <div class="flex justify-center">
          <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-end">
            <p class="text-white text-extra-bold">Lib</p>
          </div>
          <h1 class="self-center text-extra-bold">raria</h1>
        </div>
        <div class="flex flex-col gap-12">
          <p class="pt-5 flex justify-center text-inter-semi-bold">Храните знания и учитесь!</p>
          <hr class="border-blue-500 border-t-1" />
          <p class="pt-5 flex justify-center text-inter-semi-bold">Регистрация</p>
        </div>

        <Input v-model="FullName" class="mt-5 w-96" placeholder="ФИО" />
        <Input v-model="BirthDate" class="mt-5 w-96" placeholder="Дата рождения" />
        <Input v-model="Login" class="mt-5 w-96" placeholder="Придумайте логин" />
        <Input
          v-model="Password"
          class="mt-5 w-96"
          type="password"
          placeholder="Придумайте пароль"
        />
        <RadioGroup class="mt-5 ml-1 flex gap-32" v-model="selectedRole">
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
            >Пользователь с таким логином уже существует или заполнены не все поля</AlertDescription
          >
        </Alert>
        <div class="mt-12 flex gap-2">
          <Button v-model="register" @click="saveData" class="w-60 bg-blue-900"
            >Зарегестрироваться</Button
          >
          <Button class="w-36 bg-blue-500">Через VK ID</Button>
        </div>
        <Button @click="redirectToAuthPage" class="mt-5 w-96 bg-slate-50"
          ><p class="text-black">Войти</p></Button
        >
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

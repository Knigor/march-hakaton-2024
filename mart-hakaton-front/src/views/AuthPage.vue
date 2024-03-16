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
          <p class="pt-5 flex justify-center text-inter-semi-bold">Вход</p>
        </div>

        <Input class="mt-5 w-96" placeholder="Ваш логин" v-model="login" />
        <Input class="mt-5 w-96" type="password" placeholder="Пароль" v-model="password" />
        <Alert v-if="isVisible" class="mt-5" variant="destructive">
          <AlertTitle>Ошибка</AlertTitle>
          <AlertDescription>Неверно введен логин или пароль!</AlertDescription>
        </Alert>
        <div class="mt-12 flex gap-2">
          <Button @click="saveData" class="w-60 bg-blue-900">Войти</Button>

          <Button class="w-36 bg-blue-500">Через VK ID</Button>
        </div>
        <Button @click="redirectToRegisterPage" class="mt-5 w-96 bg-slate-50"
          ><p class="text-black">Забыл пароль</p></Button
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
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'
import { ref } from 'vue'
import axios from 'axios'

const router = useRouter()

const redirectToRegisterPage = () => {
  router.push({ name: 'RegistrationPage' })
}

const login = ref('')
const password = ref('')
const isVisible = ref(false)

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

    isVisible.value = status === 'error'
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

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

        <Input class="mt-5 w-96" placeholder="ФИО" />
        <Input class="mt-5 w-96" placeholder="Дата рождения" />
        <Input class="mt-5 w-96" placeholder="Придумайте логин" />
        <Input class="mt-5 w-96" type="password" placeholder="Придумайте пароль" />
        <RadioGroup class="mt-5 ml-1 flex gap-32" default-value="option-one">
          <div class="flex items-center space-x-2">
            <RadioGroupItem id="option-one" value="option-one" />
            <Label for="option-one">Я студент</Label>
          </div>
          <div class="flex items-center space-x-2">
            <RadioGroupItem id="option-two" value="option-two" />
            <Label for="option-two">Я преподаватель</Label>
          </div>
        </RadioGroup>
        <div class="mt-12 flex gap-2">
          <Button class="w-60 bg-blue-900">Зарегестрироваться</Button>
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

const router = useRouter()

const redirectToAuthPage = () => {
  router.push({ name: 'AuthPage' })
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

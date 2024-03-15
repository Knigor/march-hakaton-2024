<template>
  <div class="h-full flex flex-col justify-center">
    <Sidebar class="flex-none" />
    
    <div class="flex flex-row justify-center">
      <div class="px-10 py-5">
        <p>Libraria</p>
        <p>Храните знания и учитесь!</p>
        <Input class="mt-5 w-96" placeholder="ФИО" />
        <Input class="mt-5 w-96" placeholder="Логин пользователя" />
        <Input class="mt-5 w-96" placeholder="Пароль" />
        <Input class="mt-5 w-96" placeholder="Дата рождения" />
        <div class="type-user mt-5">
          <label class="inline-flex items-center">
            <input
              type="radio"
              class="form-radio text-blue-500"
              name="userType"
              value="student"
              v-model="userType"
            />
            <span class="ml-2">Я студент</span>
          </label>
          <label class="inline-flex items-center ml-6">
            <input
              type="radio"
              class="form-radio text-blue-500"
              name="userType"
              value="teacher"
              v-model="userType"
            />
            <span class="ml-2">Я преподаватель</span>
          </label>
        </div>

        <Button class="w-96 mt-5" variant="outline"> Войти </Button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'

// Импортируем компонент Sidebar
import Sidebar from '@/components/ui/sidebar/Sidebar.vue'
</script>

<style lang="scss" scoped></style>

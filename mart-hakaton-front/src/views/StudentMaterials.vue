<template>
  <div class="flex flex-col gap-8 h-full p-16">
    <SiteHeader />
    <main class="flex h-full gap-8">
      <nav class="h-full">
        <ProfileMenu />
      </nav>
      <div class="h-full w-full flex flex-col gap-5">
        <div class="title flex justify-between items-center">
          <p class="pt-5 flex text-inter-semi-bold">Философия</p>
          <Button @click="addMaterial" class="bg-blue-700" v-if="!isStudent">Добавить</Button>
        </div>
        <div v-for="material in materials" :key="material.id">
          <LectionCard
            :title="material.title"
            :isAudio="material.isAudio"
            :isFavorite="material.isFavorite"
            :isStudent="isStudent"
          />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import LectionCard from '../components/custom/LectionCard.vue'
import SiteHeader from '../components/custom/SiteHeader.vue'
import ProfileMenu from '../components/custom/profile/ProfileMenu.vue'
import { Button } from '@/components/ui/button'

const isStudent = ref(false) // Создаем реактивную переменную для хранения статуса студента

// Получаем значение из localStorage
const roleUser = localStorage.getItem('role_user')

console.log(localStorage)
// Если роль пользователя студент, устанавливаем isStudent в true
if (roleUser === 'student') {
  isStudent.value = true
}

const materials = [
  {
    id: 1,
    title: 'Физика',
    isAudio: true,
    isFavorite: false
  },
  {
    id: 2,
    title: 'Нано еббб]',
    isAudio: false,
    isFavorite: true
  }
]
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap');
.text-extra-bold {
  font-family: 'Inter', sans-serif;
  font-size: 32px;
}

.text-inter-semi-bold {
  font-family: 'Inter', sans-serif;
  font-weight: 600;
  font-size: 28px;
}
</style>

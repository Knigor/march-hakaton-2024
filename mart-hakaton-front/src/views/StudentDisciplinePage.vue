<template>
  <div class="flex flex-col gap-8 h-full p-16">
    <SiteHeader />
    <main class="flex h-full gap-8">
      <nav class="h-full">
        <ProfileMenu />
      </nav>
      <div class="h-full w-full flex flex-col gap-10">
        <p class="pt-5 flex text-inter-semi-bold">Дисциплины</p>
        <div class="flex flex-wrap justify-start gap-5 px-0 py-25" style="width: 100%">
          <DisplineCard
            v-for="discipline in disciplines"
            :key="discipline.id"
            :title="discipline.title"
            :faculty="discipline.faculty"
            :name-teacher="discipline.nameTeacher"
            :course="discipline.course"
            :is-student="isStudent"
          />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import DisplineCard from '../components/custom/DisciplineCard.vue'
import SiteHeader from '../components/custom/SiteHeader.vue'
import ProfileMenu from '../components/custom/profile/ProfileMenu.vue'

const isStudent = ref(false); // Создаем реактивную переменную для хранения статуса студента

const disciplines = [
  {
    id: 1,
    title: 'Математический анализ',
    faculty: 'ИКН',
    nameTeacher: 'Сувиченко Статлана',
    course: '2'
  },
  {
    id: 2,
    title: 'Физика',
    faculty: 'Физфак',
    nameTeacher: 'Иванов Иван',
    course: '1'
  }
]

// Получаем значение из localStorage
const roleUser = localStorage.getItem('role_user');

// Если роль пользователя студент, устанавливаем isStudent в true
if (roleUser === 'student') {
  isStudent.value = true;
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

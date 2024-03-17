<template>
  <div class="flex flex-col gap-8 h-full p-16">
    <SiteHeader />
    <main class="flex h-full gap-8">
      <nav class="h-full">
        <ProfileMenu />
      </nav>
      <div class="h-full w-full flex flex-col gap-10">
        <div class="title flex justify-between items-center">
          <p class="pt-5 flex text-inter-semi-bold">Дисциплины</p>
          <Button @click="addDiscipline" class="bg-blue-700" v-if="!isStudent">Добавить</Button>
        </div>
        <div class="flex flex-wrap justify-start gap-5 px-0 py-25" style="width: 100%">
          <DisplineCard
            v-for="discipline in disciplines"
            :key="discipline.id"
            :title="discipline.title"
            :faculty="discipline.faculty"
            :name-teacher="discipline.nameTeacher"
            :course="discipline.course"
            :is-student="isStudent"
            @click="redirectToMaterialsPage"
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
import { useRouter } from 'vue-router'
import axios from 'axios'

const isStudent = ref(false)
const disciplines = ref([])

const router = useRouter()

const addDiscipline = () => {
  router.push('/addSubject')
}

const redirectToMaterialsPage = () => {
  router.push('/materials')
}

// Получаем значение из localStorage
const roleUser = localStorage.getItem('role_user')

// Если роль пользователя студент, устанавливаем isStudent в true
if (roleUser === 'student') {
  isStudent.value = true
}

axios
  .get('http://localhost/get_subject.php')
  .then((response) => {
    // Очищаем массив disciplines
    disciplines.value = []

    // Заполняем массив disciplines значениями из response.data
    response.data.forEach((item) => {
      disciplines.value.push({
        id: item.subject_id,
        title: item.name_item,
        faculty: item.faculty,
        nameTeacher: item.full_name_user,
        course: item.class
      })
    })

    console.log(disciplines.value) // Перемещаем console.log внутрь обработчика .then()
  })
  .catch((error) => {
    console.error('Ошибка при получении данных:', error)
  })
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

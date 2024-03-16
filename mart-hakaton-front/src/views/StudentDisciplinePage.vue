<template>
  <div class="h-full flex flex-col gap-10">
    <p class="pt-5 flex text-inter-semi-bold">Дисциплины</p>
    <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 px-0 py-25"
    >
      <div v-for="discipline in disciplines" :key="discipline.id">
        <DisplineCard
          :title="discipline.title"
          :faculty="discipline.faculty"
          :name-teacher="discipline.nameTeacher"
          :course="discipline.course"
          :is-student="true"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import DisplineCard from '../components/custom/DisciplineCard.vue'

const disciplines = [
  {
    id: 1,
    title: 'Математический анализ',
    faculty: 'ИКН',
    nameTeacher: 'Сувиченко Статлана',
    course: 2
  },
  {
    id: 2,
    title: 'Физика',
    faculty: 'Физфак',
    nameTeacher: 'Иванов Иван',
    course: 1
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
  font-weight: 600; /* Semi-Bold вес шрифта */
  font-size: 28px;
}
</style>

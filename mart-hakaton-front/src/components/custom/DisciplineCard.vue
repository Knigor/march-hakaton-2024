<template>
  <div class="rectangle p-4 rounded-lg" @click="selectDiscipline">
    <div class="text-xl text-inter-title mb-1">{{ title }}</div>
    <div class="faculty flex">
      <img src="@/img/hexagon.svg" class="mr-2" alt="" />
      <div class="flex justify-center text-inter-info">{{ faculty }}</div>
    </div>
    <div class="course flex">
      <img src="@/img/graduation-cap.svg" class="mr-2" alt="" />
      <div class="text-inter-info">{{ course }} курс</div>
    </div>
    <div class="teacher flex justify-start" v-if="isStudent">
      <img src="@/img/person-standing.svg" class="mr-2" alt="" />
      <div class="text-inter-info">{{ nameTeacher }}</div>
    </div>
    <div class="delete flex edit flex justify-end" v-else>
      <img
        src="@/img/trash.svg"
        class="w-7 h-7 p-1"
        alt=""
        @click="handleDeleteClick"
        style="background-color: #f87171; border-radius: 90px; border: 2px solid #fecaca"
      />
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    handleDeleteClick() {
      console.log('Иконка delete была нажата')
    },
    selectDiscipline() {
      console.log('Переход на конкретную дисциплину')
    }
  },
  props: {
    title: {
      type: String,
      required: true
    },
    faculty: {
      type: String,
      required: true
    },
    course: {
      type: String,
      required: true
    },
    nameTeacher: {
      type: String,
      required: true
    },
    isStudent: {
      type: Boolean,
      required: true
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap');
.text-inter-info {
  font-family: 'Inter', sans-serif;
  font-size: 12px;
  color: #64748b;
}

.text-inter-title {
  font-family: 'Inter', sans-serif;
  font-size: 20px;
  font-weight: 500;
  color: #0f172a;
}
/* 0F172A */

.rectangle {
  width: 300px;
  border: solid 1px;
  border-color: #e5e7eb;
  background-color: white;

  /* You can adjust width as per your requirement */
}
</style>
<template>
  <div class="h-full flex flex-col gap-10">
    <p class="pt-5 flex text-inter-semi-bold">Философия</p>
    <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 px-0 py-25"
    >
      <LectionCard :title="Заголовок" :isAudio="true" :isFavorite="true" />
      <!-- <div v-for="material in materials" :key="material.id">
        <LectionCard
          :title="material.title"
          :isAudio="material.isAudio"
          :isFavorite="material.isFavorite"
        />
      </div> -->
    </div>
  </div>
</template>

<script setup>
import LectionCard from '../components/custom/LectionCard.vue'

// const materials = [
//   {
//     id: 1,
//     title: 'Физика',
//     isAudio: true,
//     isFavorite: false
//   },
//   {
//     id: 2,
//     title: 'Нано еббб]',
//     isAudio: false,
//     isFavorite: true
//   }
// ]
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

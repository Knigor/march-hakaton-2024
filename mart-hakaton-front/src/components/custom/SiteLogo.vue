<template>
  <!-- Контейнер для всего лого -->
  <div class="flex items-center h-[64px] gap-6">
    <!-- Контейнер только для лого -->
    <div class="flex items-center w-[136px]">
      <!-- Круг -->
      <div class="h-16 w-16 rounded-full bg-blue-500"></div>
      <!-- Текст логотипа -->
      <h1 class="absolute left-4 text-extra-bold text-lg"><span class="text-white">Lib</span>raria</h1>
    </div>
    <!-- Разделитель -->
    <div class="h-2/3 w-px bg-blue-200"></div>
    <!-- Слоган -->
    <p class="text-inter-semi-bold text-lg">Храните знания и учитесь!</p>
  </div>
</template>

<!-- Старый вариант логотипа -->
<!-- <div class="flex justify-center">
  <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-end">
    <p class="text-white text-extra-bold">Lib</p>
  </div>
  <h1 class="self-center text-extra-bold">raria</h1>
</div>
<div class="flex flex-col gap-12">
  <p class="pt-5 flex justify-center text-inter-semi-bold">Храните знания и учитесь!</p> -->

<script setup></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
.text-extra-bold {
  font-family: 'Inter', sans-serif;
  font-size: 32px;
  font-weight: bold;
}

.text-inter-semi-bold {
  font-family: 'Inter', sans-serif;
  font-weight: 500; /* Semi-Bold вес шрифта */
  font-size: 18px;
}
</style>

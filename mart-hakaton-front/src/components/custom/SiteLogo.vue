<script setup></script>

<template>
  <!-- Контейнер для всего лого -->
  <div class="flex items-center h-[64px] gap-4 w-fit">
    <!-- Контейнер только для лого -->
    <div class="flex items-center max-w-[138px]">
      <!-- Круг -->
      <div class="min-h-16 min-w-16 max-h-16 max-w-16 rounded-full bg-blue-500"></div>
      <!-- Текст логотипа -->
      <h1 class="relative -left-12 font-bold text-[32px]"><span class="text-white">Lib</span>raria</h1>
    </div>
    <!-- Разделитель -->
    <div class="h-2/3 w-px bg-blue-200"></div>
    <!-- Слоган -->
    <p class="text-lg font-base">Храните знания и учитесь!</p>
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

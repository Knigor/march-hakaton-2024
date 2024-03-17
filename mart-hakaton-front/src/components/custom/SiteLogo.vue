<script setup>
import { defineProps } from 'vue'

defineProps({
  isVertical: Boolean // Определяет вид логотипа: вертикальное или горизонтальное отображение
})
</script>

<template>
  <!-- Контейнер для всего лого -->
  <div class="flex items-center h-[64px] gap-4 w-fit" :class="{ 'flex-col': isVertical }">
    <!-- Контейнер только для лого -->
    <div class="flex items-center max-w-[138px]">
      <!-- Круг -->
      <div class="min-h-16 min-w-16 max-h-16 max-w-16 rounded-full bg-blue-500"></div>
      <!-- Текст логотипа -->
      <h1 class="relative -left-12 font-bold text-[32px]"><span class="text-white">Lib</span>raria</h1>
    </div>
    <!-- Разделитель -->
    <div v-if="!isVertical" class="h-2/3 w-px bg-blue-200"></div>
    
    <!-- Слоган -->
    <p class="text-lg font-base">Храните знания и учитесь!</p>
  </div>
</template>

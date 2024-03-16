<script setup>
import { User, Book, Star, Settings } from 'lucide-vue-next'
import ProfileMenuElement from './ProfileMenuElement.vue'

function deselectOthers() {
  
}

</script>

<template>
  <div @deselectOthers="deselectOthers" class="flex flex-col w-[360px]">
    <ProfileMenuElement>
      <template #icon><User /></template>
      Профиль
    </ProfileMenuElement>
    <ProfileMenuElement :submenus="[{ id: 0, label: 'Теория вероятностей' }]">
      <template #icon><Book /></template>
      Дисциплины
    </ProfileMenuElement>
    <ProfileMenuElement>
      <template #icon><Star /></template>
      Избранные лекции
    </ProfileMenuElement>
    <ProfileMenuElement>
      <template #icon><Settings /></template>
      Настройки
    </ProfileMenuElement>
  </div>
</template>

<script setup>
import { User, Book, Star, Settings, LogOut, Minimize } from 'lucide-vue-next'
import ProfileMenuElement from './ProfileMenuElement.vue'
import { Button } from '@/components/ui/button'
import Card from '@/components/ui/card/Card.vue'

function deselectOthers() {}
</script>

<template>
  <Card
    @deselectOthers="deselectOthers"
    class="flex flex-col w-[360px] h-full gap-3 justify-between"
  >
    <div class="flex flex-col h-full">
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
    <div class="flex flex-col gap-1">
      <Button variant="ghost"><Minimize />Свернуть</Button>
      <Button variant="ghost"><LogOut />Выйти</Button>
    </div>
  </Card>
</template>

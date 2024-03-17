<script setup>
import { User, Book, Star, Settings, LogOut, Minimize } from 'lucide-vue-next'
import ProfileMenuElement from './ProfileMenuElement.vue'
import { Button } from '@/components/ui/button'
import Card from '@/components/ui/card/Card.vue'
</script>

<template>
  <Card class="bg-white h-full justify-between">
    <nav class="flex flex-col max-w-[360px] w-[360px] h-full gap-3">
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
        <Button variant="ghost" class="flex"
          ><Minimize />
          <p class="w-full">Свернуть</p></Button
        >
        <Button variant="ghost" class="flex"
          ><LogOut />
          <p class="w-full">Выйти</p></Button
        >
      </div>
    </nav>
  </Card>
</template>

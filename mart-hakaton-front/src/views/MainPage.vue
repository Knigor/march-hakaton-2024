<script setup>
import SiteHeader from '../components/custom/SiteHeader.vue'
import ProfileMenu from '../components/custom/profile/ProfileMenu.vue'

import { Card } from '../components/ui/card'
</script>

<template>
  <div class="flex flex-col gap-8 h-full p-16">
    <SiteHeader />
    <main class="flex h-full gap-8">
      <nav class="h-full">
        <ProfileMenu />
      </nav>
      <section class="flex h-full gap-6">
        <!-- Первая колонка -->
        <div class="w-full">
          <Card class="flex flex-col">Последние просмотренные</Card>
        </div>
        <!-- Вторая колонка -->
        <div>
          <Card>Профиль</Card>
          <Card>Избранное</Card>
        </div>
      </section>
    </main>
  </div>
</template>

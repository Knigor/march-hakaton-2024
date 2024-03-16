<script setup>
import { Button } from '@/components/ui/button'
import { StarOff } from 'lucide-vue-next'
</script>

<template>
  <div class="flex flex-col w-full gap-1 pr-4">
    <div class="flex w-full justify-between">
      <h3 class="font-medium text-xl">Уровни связности графов</h3>
      <Button variant="outline" size="icon" class="w-8 h-8 rounded-full"
        ><StarOff size="16"
      /></Button>
    </div>
    <p>Системный анализ</p>
  </div>
</template>

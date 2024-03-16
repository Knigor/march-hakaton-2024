<template>
  <div class="flex flex-col w-[360px] gap-1">
    <Button class="flex justify-start"><User class="mr-3" /> Профиль</Button>
    <Collapsible class="w-full h-fit" v-model:open="isOpen">
      <CollapsibleTrigger class="w-full"><Button class="flex justify-start w-full"><Book class="mr-3" /> Дисциплины</Button></CollapsibleTrigger>
      <CollapsibleContent class="flex flex-col gap-1 pl-12 mt-1 w-full">
        <Button class="flex justify-start w-full">Теория вероятностей</Button>
        <Button class="flex justify-start w-full">Базы данных</Button>
        <Button class="flex justify-start w-full"><CornerDownRight class="mr-3" />Прикладная физическая культура</Button>
      </CollapsibleContent>
    </Collapsible>
    <Button class="flex justify-start"><Star class="mr-3" /> Избранные лекции</Button>
    <Button class="flex justify-start"><Settings class="mr-3" /> Настройки</Button>
  </div>
</template>

<script setup>
import { User, Book, Star, Settings, CornerDownRight } from 'lucide-vue-next'
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible'

import { Button } from '@/components/ui/button'

import { ref } from 'vue'

const isOpen = ref(false)
</script>

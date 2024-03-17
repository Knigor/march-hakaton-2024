<script setup>
import { defineProps } from 'vue'
import { Button } from '@/components/ui/button'
import { StarOff } from 'lucide-vue-next'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'

const props = defineProps({
  title_lection: String,
  name_item: String
})
</script>

<template>
  <div class="flex flex-col w-full gap-1 pr-4">
    <div class="flex w-full justify-between">
      <h3 class="font-medium text-xl">{{ props.title_lection }}</h3>
      <TooltipProvider>
        <Tooltip>
          <TooltipTrigger>
            <template v-slot:default>
              <Button variant="outline" size="icon" class="w-8 h-8 rounded-full">
                <StarOff size="16" />
              </Button>
            </template>
          </TooltipTrigger>
          <TooltipContent>
            <p>Удалить из избранного</p>
          </TooltipContent>
        </Tooltip>
      </TooltipProvider>
    </div>
    <p>{{ props.name_item }}</p>
  </div>
</template>

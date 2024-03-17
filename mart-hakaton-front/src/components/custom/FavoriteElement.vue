<script setup>
import { Button } from '@/components/ui/button'
import { StarOff } from 'lucide-vue-next'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'
</script>

<template>
  <div class="flex flex-col w-full gap-1 pr-4">
    <div class="flex w-full justify-between">
      <h3 class="font-medium text-xl">Уровни связности графов</h3>
      <TooltipProvider>
                  <Tooltip>
                    <TooltipTrigger
                      ><Button variant="outline" size="icon" class="w-8 h-8 rounded-full"
        ><StarOff size="16"
      /></Button></TooltipTrigger>
                    <TooltipContent>
                      <p>Удалить из избранного</p>
                    </TooltipContent>
                  </Tooltip>
                </TooltipProvider>
      
    </div>
    <p>Системный анализ</p>
  </div>
</template>

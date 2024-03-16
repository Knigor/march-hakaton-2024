<script setup>
import { CornerDownRight, ChevronDown, ChevronRight } from 'lucide-vue-next'
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible'

import { Button } from '@/components/ui/button'

import { ref } from 'vue'

const isOpen = ref(false)
const isSelect = ref(false)
const isSubmenu = ref(false)

const props = defineProps(['submenus'])

if (props.submenus) {
  isSubmenu.value = true
}

function makeSelected() {
  emit('deselectOthers')
  isSelect.value = true
}
</script>

<template>
  <Collapsible @click="makeSelected" class="flex flex-col w-full h-fit" v-model:open="isOpen">
    <CollapsibleTrigger class="w-full"
      ><Button variant="ghost" class="flex justify-between w-full">
        <div class="flex justify-start gap-3">
          <CornerDownRight v-if="isSelect" />
          <slot name="icon"></slot>
          <slot></slot>
        </div>
        <ChevronDown v-show="isSubmenu" v-if="isOpen" />
        <ChevronRight v-show="isSubmenu" v-if="!isOpen" /> </Button
    ></CollapsibleTrigger>
    <CollapsibleContent class="flex flex-col gap-1 pl-12 mt-1 w-full">
      <ProfileMenuElement v-for="menu in submenus" :key="menu.id">
        {{ menu.label }}
      </ProfileMenuElement>
    </CollapsibleContent>
  </Collapsible>
</template>

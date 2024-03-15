<script setup>
import { useVModel } from '@vueuse/core'
import { cn } from '@/lib/utils'

const props = defineProps({
  defaultValue: { type: [String, Number], required: false },
  modelValue: { type: [String, Number], required: false },
  class: { type: null, required: false }
})

const emits = defineEmits(['update:modelValue'])

const modelValue = useVModel(props, 'modelValue', emits, {
  passive: true,
  defaultValue: props.defaultValue
})
</script>

<template>
  <input
    v-model="modelValue"
    :class="
      cn(
        'flex h-10 rounded-md border border-input px-3 py-2 text-sm outline-none w-96 border-purple-500 bg-purple-200 focus:border-transparent focus:ring-purple-500 focus:ring-2',
        props.class
      )
    "
  />
</template>

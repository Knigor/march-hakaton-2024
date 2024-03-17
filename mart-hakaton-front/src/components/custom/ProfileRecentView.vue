<script>
import { CalendarClock } from 'lucide-vue-next'

export default {
  props: {
    // определите необходимые пропсы для вашей карточки (например, title, faculty и т. д.)
    date: {
      type: String,
      required: true
    },
    title_lection: {
      type: String,
      required: true
    },
    full_name_user: {
      type: String,
      required: true
    }
  },
  
}

</script>

<template>
  <div class="flex flex-col gap-1">
    <h3 class="font-medium text-xl">{{ title_lection }}</h3>
    <p class="text-gray-400 text-lg">{{ full_name_user }}</p>
    <div class="flex gap-1 text-gray-400 text-sm items-center">
      <CalendarClock size="16" />
      <p>{{ date }}</p>
    </div>
  </div>
</template>

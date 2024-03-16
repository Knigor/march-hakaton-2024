<script setup>
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Search } from 'lucide-vue-next'
</script>

<template>
  <div class="flex justify-end gap-1">
    <Input type="text" placeholder="Что вы ищете?" class="font-light"></Input>
    <Button variant="outline" size="icon"><Search size="16" /></Button>
  </div>
</template>

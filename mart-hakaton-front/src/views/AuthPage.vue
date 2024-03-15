<template>
  <div class="h-full flex flex-col justify-center">
    <div class="flex flex-row justify-center">
      <div class="">
        <div>
          <p>Libraria</p>
          <p>Храните знания и учитесь!</p>
        </div>
        <div class="mt-20">
          <p class="flex justify-center">Войти</p>
          <Input class="mt-5" placeholder="Логин пользователя" />
          <Input class="mt-5" placeholder="Пароль" />
          <div class="flex flex-row">
            <Button class="w-64">Войти</Button>
            <Button class="w-32">Через VK ID</Button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
</script>

<style lang="scss" scoped></style>

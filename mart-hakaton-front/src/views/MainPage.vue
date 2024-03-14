<script setup>
import { Button } from '../components/ui/button'

import { Separator } from 'radix-vue'

import ImagePlaceholder from '../components/ui/button/ImagePlaceholder.vue'
</script>

<template>
  <main>
    <div class="mb-8 mt-20">
      <div class="mb-10 flex flex-row justify-center items-center">
        <h1 class="mr-10 text-7xl text-blue-600 font-bold">Libraria</h1>
        <ImagePlaceholder class="w-24 h-24 bg-blue-600" />
        <p class="ml-10 text-3xl text-blue-600 font-bold">Читайте по-новому!</p>
      </div>
      <Separator
        orientation="horizontal"
        class="data-[orientation=horizontal]:bg-gray-300 data-[orientation=horizontal]:h-px"
      />
    </div>
    <div class="flex flex-col h-full items-center justify-evenly">
      <div class="flex justify-between gap-52 px-32">
        <div
          class="flex max-w-xl px-12 py-6 bg-white border border-gray-250 rounded flex-col justify-center items-center"
        >
          <ImagePlaceholder class="mb-3 w-16 h-16 border-4 border-blue-500" />
          <p class="font-medium text-gray-500">100 000+ произведений</p>
        </div>
        <div
          class="flex max-w-xl px-12 py-6 bg-white border border-gray-250 rounded flex-col justify-center items-center"
        >
          <ImagePlaceholder class="mb-3 w-16 h-16 border-4 border-blue-500" />
          <p class="font-medium text-gray-500">Делитесь и обсуждайте</p>
        </div>
        <div
          class="flex max-w-xl px-12 py-6 bg-white border border-gray-250 rounded flex-col justify-center items-center"
        >
          <ImagePlaceholder class="mb-3 w-16 h-16 border-4 border-blue-500" />
          <p class="font-medium text-gray-500">Сохраняйте понравившееся</p>
        </div>
      </div>
      <div class="flex flex-col gap-3 items-center">
        <Button>Приступить</Button>
        <p class="text-blue-600">Уже с нами?</p>
      </div>
    </div>
  </main>
</template>

<style>
@import '@radix-ui/colors/indigo.css';
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

body {
  background-color: var(--indigo-3);
  display: flex;
  flex-direction: column;
  padding: 64px;
  font-family: Roboto, sans-serif;
  height: 100vh;
}
</style>

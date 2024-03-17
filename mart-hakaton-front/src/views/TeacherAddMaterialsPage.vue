<template>
  <div class="flex flex-col gap-8 h-full p-16">
    <SiteHeader />
    <main class="flex h-full gap-8">
      <nav class="h-full">
        <ProfileMenu />
      </nav>
      <div class="h-full w-full flex flex-col gap-10">
        <div class="flex flex-row w-full">
          <div class="px-10 py-5 w-full">
            <p class="text-xl text-inter-title mb-1">Добавление материала для</p>
            <Input class="mt-5 mb-5 w-full" placeholder="Введите название" />

            <div class="flex items-center justify-center w-full">
              <label
                for="dropzone-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
              >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                  <svg
                    class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 16"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                    />
                  </svg>
                  <p
                    class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                    style="text-align: center"
                  >
                    <span class="font-semibold">Перетащите файл с материалом в это окно.</span
                    ><br />
                    Материал может быть текстом или голосовой записью
                  </p>

                  <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    (.md, .txt, .mp3, .ogg, не более 25 МБ)
                  </p>
                  <p
                    class="mt-3 text-sm text-gray-500 dark:text-gray-400"
                    style="text-align: center"
                  >
                    <span class="font-semibold"><em>Для выбора нажмите на это окно.</em></span>
                  </p>
                </div>
                <input id="dropzone-file" type="file" class="hidden" />
              </label>
            </div>

            <div class="flex justify-between mt-5 w-full">
              <Button> Вернуться </Button>
              <Button> Опубликовать </Button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SiteHeader from '../components/custom/SiteHeader.vue'
import ProfileMenu from '../components/custom/profile/ProfileMenu.vue'

import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap');
.text-inter-title {
  font-family: 'Inter', sans-serif;
  font-size: 20px;
  font-weight: 500;
  color: #0f172a;
}
</style>

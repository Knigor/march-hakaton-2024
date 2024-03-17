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
            <p class="text-xl text-inter-title mb-1">Создание дисциплины</p>
            <Input v-model="disciplineName" class="mt-5 mb-5" placeholder="Введите название" />

            <div class="relative">
              <select
                v-model="faculty"
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
              >
                <option>Факультет</option>
                <option>ИКН</option>
                <option>ИСА</option>
                <option>ЗФ</option>
                <option>ФДО</option>
                <option>ИМиТ</option>
                <option>МИ</option>
                <option>ИСНэП</option>
                <option>УК</option>
              </select>
              <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
              >
                <svg
                  class="fill-current h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M8.293 14.707a1 1 0 011.414 0L12 16.586V3a1 1 0 112 0v13.586l2.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  />
                </svg>
              </div>
            </div>

            <div class="relative mt-5">
              <select
                v-model="course"
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
              >
                <option>Курс</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
              <div
                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
              >
                <svg
                  class="fill-current h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M8.293 14.707a1 1 0 011.414 0L12 16.586V3a1 1 0 112 0v13.586l2.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  />
                </svg>
              </div>
            </div>

            <p class="mt-5 mb-2">Обложка дисциплины</p>
            <div class="flex items-center justify-center w-full">
              <label
                for="dropzone-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
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
                    <span class="font-semibold">Перетащите изображение обложки в это окно.</span
                    ><br />
                  </p>

                  <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    (только форматы .png, .jpg)
                  </p>
                  <p
                    class="mt-3 text-sm text-gray-500 dark:text-gray-400"
                    style="text-align: center"
                  >
                    <span class="font-semibold"><em>Для выбора нажмите на это окно.</em></span>
                  </p>
                </div>
                <input @change="handleFileUpload" id="dropzone-file" type="file" class="hidden" />
              </label>
            </div>
            <Alert v-if="successAlert" class="mt-5 bg-green-300">
              <Terminal class="h-4 w-4" />
              <AlertTitle>Успешно</AlertTitle>
              <AlertDescription> Данные добавленны </AlertDescription>
            </Alert>
            <div class="flex justify-between mt-5">
              <Button @click="backPage" class="bg-blue-700"> Вернуться </Button>
              <Button @click="saveData" class="bg-blue-700"> Опубликовать </Button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import LectionCard from '../components/custom/LectionCard.vue'
import SiteHeader from '../components/custom/SiteHeader.vue'
import ProfileMenu from '../components/custom/profile/ProfileMenu.vue'
import { useRouter } from 'vue-router'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import axios from 'axios'
import { Terminal } from 'lucide-vue-next'
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert'

const router = useRouter()

const disciplineName = ref('')
const faculty = ref('')
const course = ref('')

const coverImage = ref(null)

let successAlert = ref(false)

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    coverImage.value = file
  }
}

const backPage = () => {
  router.push('/discipline')
}

async function saveData() {
  // Создаем экземпляр FormData для отправки данных формы
  const formData = new FormData()
  formData.append('name_item', disciplineName.value)
  formData.append('faculty', faculty.value)
  formData.append('class', course.value)
  formData.append('foto', coverImage.value)
  formData.append('id_user', localStorage.id_user)

  console.log(formData)

  try {
    const response = await axios.post('http://localhost/add_subject.php', formData, {
      headers: {
        'Content-Type': 'multipart/form-data' // Указываем правильный заголовок для отправки файлов
      }
    })
    const status = response.data.status

    console.log(response.data)
    console.log('Ответ от сервера:', status)

    if (status === 'success') {
      successAlert.value = true
    }
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}
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

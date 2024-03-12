<template>
  <div>
    <button @click="sendData">GET запрос</button>
    <div>{{ outUser }}</div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const userData = ref(null)

const outUser = ref(null)

const sendData = () => {
  axios
    .get('http://localhost:8001/user.php?name=Igor&age=22')
    .then((response) => {
      userData.value = response.data
      console.log('Ответ от сервера:', userData.value)
      outUser.value = userData.value.name + ' ' + userData.value.age
    })
    .catch((error) => {
      console.error('Ошибка при получении данных:', error)
    })
}
</script>

<style lang="scss" scoped></style>

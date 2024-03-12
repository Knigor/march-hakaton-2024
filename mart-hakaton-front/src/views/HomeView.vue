<template>
  <button @click="sendData">POST запрос</button>
</template>

<script setup>
import axios from 'axios'

async function sendData() {
  const userData = {
    email: 'john@example.com',
    password: '12345'
  }

  try {
    const response = await axios.post('http://localhost:8001/index.php', userData)
    console.log('Ответ от сервера:', response.data)
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}
</script>

<style lang="scss" scoped></style>

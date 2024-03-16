<template>
    <div class="rectangle p-4 rounded-lg">
      <div class="audio" v-if="isAudio">
        <img src="@/img/voicemail.svg" class="mr-2" alt="" />
      </div>
      <div class="text-xl text-inter-title mb-1">Лекция{{ title }}</div>
      <div class="favorite flex">
        <img :src="isFavorite ? require('@/img/star.svg') : require('@/img/star-1.svg')" class="mr-2" alt="" />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      title: {
        type: String,
        required: true
      },
      isAudio: {
        type: Boolean,
        required: true
      },
      isFavorite: {
        type: Boolean,
        required: true
      },
    }
  }
  </script>
  
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@800&display=swap');
  .text-inter-info {
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    color: #64748b;
  }
  
  .text-inter-title {
    font-family: 'Inter', sans-serif;
    font-size: 20px;
    font-weight: 500;
    color: #0f172a;
  }
  
  .rectangle {
    width: 300px;
    border: solid 1px;
    border-color: #e5e7eb;
    background-color: white;
  }
  </style>
  
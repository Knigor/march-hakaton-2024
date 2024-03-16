<template>
  <div class="box p-4 rounded-lg flex items-center justify-between">
    <div class="titles flex items-center">
      <div class="audio">
        <img src="@/img/voicemail.svg" class="mr-2 w-5 h-5" v-if="isAudio" alt="" />
        <div class="mr-2 w-6 h-5" v-else></div>
      </div>
      <div class="text-xl text-inter-title mb-1">{{ title }}</div>
    </div>
    <div class="favorite flex">
      <img
        src="@/img/star.svg"
        class="mr-2"
        alt=""
        v-if="isFavorite"
        @click="handleFavoriteClick"
      />
      <img src="@/img/star-1.svg" class="mr-2" alt="" v-else @click="handleFavoriteClick" />
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
    }
  },
  methods: {
    handleFavoriteClick() {
      console.log('Иконка favorite была нажата')
    }
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

.box {
  width: 98vw;
  border: solid 1px;
  border-color: #e5e7eb;
  background-color: white;
}
</style>

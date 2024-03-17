<template>
  <div class="box p-3 rounded-lg flex items-center justify-between" @click="selectLection">
    <div class="titles flex items-center">
      <div class="audio">
        <img src="@/img/voicemail.svg" class="mr-2 w-5 h-5" v-if="isAudio" alt="" />
        <div class="mr-2 w-6 h-5" v-else></div>
      </div>
      <div class="text-xl text-inter-title mb-1">{{ title }}</div>
    </div>
    <div class="action flex edit flex justify-end">
      <div class="favorite flex">
        <img
          src="@/img/star.svg"
          class="w-7 h-7 p-1"
          alt=""
          v-if="isFavorite"
          @click="handleFavoriteClick"
          style="border-radius: 90px; border: 2px solid #e2e8f0"
        />
        <img
          src="@/img/star-1.svg"
          class="w-7 h-7 p-1"
          alt=""
          v-else
          @click="handleFavoriteClick"
          style="border-radius: 90px; border: 2px solid #e2e8f0"
        />
      </div>
      <img
        src="@/img/pencil.svg"
        class="w-7 h-7 p-1 ml-5"
        alt=""
        v-if="!isStudent"
        style="border-radius: 90px; border: 2px solid #e2e8f0"
      />
      <img
        src="@/img/trash.svg"
        class="w-7 h-7 p-1 ml-5"
        alt=""
        @click="handleDeleteClick"
        v-if="!isStudent"
        style="background-color: #f87171; border-radius: 90px; border: 2px solid #fecaca"
      />
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
    isStudent: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    handleFavoriteClick() {
      console.log('Иконка favorite была нажата')
    },
    selectLection() {
      this.$router.push('/materials/read')
      console.log('Переход на конкретную лекцию')
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
  /* width: 98vw; */
  border: solid 1px;
  border-color: #e5e7eb;
  background-color: white;
}
</style>

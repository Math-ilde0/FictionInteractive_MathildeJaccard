<template>
  <div
    class="font-[Dancing_Script] bg-[#f4f1e3] text-[#333] leading-relaxed min-h-screen pt-10 overflow-y-auto"
  >
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  components: {
  }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap');

/* Animation Vue.js transition */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

<template>
  <div>
    <router-view></router-view> <!-- Vue Router rendra le contenu ici -->
    
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap');

body {
  font-family: 'Dancing Script', cursive;
  margin: 0;
  padding: 40px 0;
  background-color: #f4f1e3;
  color: #333;
  line-height: 1.6;
  overflow-y: auto;
}

main {
  display: block;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

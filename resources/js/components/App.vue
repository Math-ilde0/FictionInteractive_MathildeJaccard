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
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap');

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
</style>

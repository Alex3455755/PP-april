<template>
  <div class="app">

    <!-- 🔥 ГЛОБАЛЬНЫЙ ФОН -->
    <img src="/img/fon.png" class="bg-image" />

    
    <router-view />

  </div>
</template>

<script>


</script>

<style>
.app {
  position: relative;
  min-height: 100vh;
  overflow: hidden;
}

.bg-image {
  position: fixed;
  top: 0;
  left: 0;

  width: 100%;
  height: 100%;

  object-fit: cover;
  z-index: -1;
  filter: brightness(0.82);
}

*{
  font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
}
</style>
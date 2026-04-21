<template>
  <div class="app">

    <!-- 🔥 ГЛОБАЛЬНЫЙ ФОН -->
    <img src="/img/fon.png" class="bg-image" />

    <AppMenu />
    <router-view />

  </div>
</template>

<script>
import AppMenu from './components/items/AppMenu.vue'

export default {
  components: { AppMenu }
}
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
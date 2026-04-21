<template>
  <AppMenu />
  <router-view />
</template>

<script>
import AppMenu from './components/items/AppMenu.vue'

export default {
  name: 'App',
  components: {
    AppMenu
  }
}
</script>
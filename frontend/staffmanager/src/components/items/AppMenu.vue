<template>
  <header class="topbar">

    <!-- LOGO -->
    <div class="logo">
      <div class="logo-icon">N</div>
      <div class="logo-text">
        <h2>НОВОМЕТ</h2>
        <span>HR SYSTEM</span>
      </div>
    </div>

    <!-- NAV -->
    <nav v-if="isLoaded" class="nav">
      <div 
        v-for="item in navItems" 
        :key="item.id"
        class="nav-item"
        :class="{ 'router-link-active': isActive(item.path) }"
        @click="navigate(item.path)"
      >
        {{ item.name }}
      </div>
    </nav>

    <!-- RIGHT -->
    <div class="right">
      <button v-if="user" class="logout-btn" @click="logout">
        Выход
      </button>
    </div>

  </header>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const user = ref(null)
const isLoaded = ref(false)

// 🔥 запрос пользователя
const fetchUser = async () => {
  try {

    const res = await fetch('http://localhost:8000/api/user', {
      credentials: 'include',
    })

    if (!res.ok) throw new Error('Unauthorized')
    
    const data = await res.json()
    user.value = data

  } catch (e) {
    user.value = null
  } finally {
    isLoaded.value = true
  }
}

// 🔥 динамическое меню
const navItems = computed(() => {

  const u = user.value

  if (!u) {
    return [
      { id: 1, name: 'Вакансии', path: '/' },
      { id: 2, name: 'Вход', path: '/login' },
    ]
  }

  if (Number(u.data.role) === 1) {
    return [
      { id: 1, name: 'Вакансии', path: '/' },
      { id: 2, name: 'Админка', path: '/admin' },
      { id: 3, name: 'Чаты', path: '/chats' },
      { id: 4, name: 'Заявки', path: '/applications' },
      { id: 5, name: 'Профиль', path: '/profile' },
    ]
  }

  return [
    { id: 1, name: 'Вакансии', path: '/' },
    { id: 2, name: 'Профиль', path: '/profile' },
    { id: 3, name: 'Чаты', path: '/chats' },
  ]
})

// активный пункт
const isActive = (path) => route.path === path

// переход
const navigate = (path) => {
  if (route.path !== path) {
    router.push(path)
  }
}

// выход
const logout = () => {
  localStorage.removeItem('token')
  user.value = null
  router.push('/login')
}

onMounted(() => {
  fetchUser()
})
</script>

<style scoped>
.topbar {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;

  height: 70px;
  padding: 0 25px;

  display: flex;
  align-items: center;
  justify-content: space-between;

  background: rgba(255, 255, 255, 0.10);
  backdrop-filter: blur(22px);

  border-bottom: 1px solid rgba(255, 255, 255, 0.18);

  color: white;
  z-index: 9999;
}

/* LOGO */
.logo {
  display: flex;
  align-items: center;
  gap: 12px;
}

.logo-icon {
  width: 40px;
  height: 40px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 14px;

  background: rgba(255, 140, 40, 0.25);
  border: 1px solid rgba(255, 160, 60, 0.5);

  font-weight: 800;
  font-size: 18px;
}

.logo-text h2 {
  font-size: 16px;
  margin: 0;
}

.logo-text span {
  font-size: 11px;
  opacity: 0.6;
}

/* NAV */
.nav {
  display: flex;
  gap: 12px;
}

.nav-item {
  padding: 10px 14px;
  border-radius: 14px;

  color: rgba(255,255,255,0.85);

  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);

  transition: 0.3s;
  cursor: pointer;
}

.nav-item:hover {
  background: rgba(255, 140, 40, 0.15);
  transform: translateY(-2px);
}

.router-link-active {
  background: rgba(255, 140, 40, 0.25);
  border: 1px solid rgba(255, 160, 60, 0.5);
  color: #ffb36b;
}

/* RIGHT */
.right {
  display: flex;
  align-items: center;
}

.logout-btn {
  padding: 10px 14px;
  border-radius: 14px;

  border: 1px solid rgba(255, 80, 80, 0.4);
  background: rgba(255, 80, 80, 0.12);

  color: #ff6b6b;
  cursor: pointer;
  transition: 0.3s;
}

.logout-btn:hover {
  background: rgba(255, 80, 80, 0.25);
  transform: translateY(-2px);
}
</style>
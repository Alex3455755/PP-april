<template>
  <header class="topbar">

    <div class="logo">
      <div class="logo-icon">N</div>
      <div class="logo-text">
        <h2>НОВОМЕТ</h2>
        <span>HR SYSTEM</span>
      </div>
    </div>

    <nav class="nav">
      <router-link to="/admin" class="nav-item">Вакансии</router-link>
      <router-link to="/application" class="nav-item">Заявки</router-link>
      <router-link to="/chats" class="nav-item">Чаты</router-link>
    </nav>

    <div class="right">
      <button class="logout-btn" @click="logout">Выход</button>
    </div>

  </header>
</template>

<script setup>
/* global defineProps */

const logout = () => {
  localStorage.removeItem('token')
  location.href = '/login'
}

defineProps({
  userRole: {
    type: Number,
    default: null
  }
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

  text-decoration: none;
  color: rgba(255,255,255,0.85);

  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.08);

  transition: 0.3s;
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
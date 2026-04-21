<template>
  <div class="wrapper">
    <img
      :src="backgroundImage"
      alt="Background"
      class="bg-image"
    >

    <div class="glass-form">
      <div class="title-block">
        <p class="subtitle">ACCESS PANEL</p>
        <h1 class="title">АВТОРИЗАЦИЯ</h1>
        <p class="desc">Войдите в систему для продолжения работы</p>
      </div>

      <form @submit.prevent="submitLogin" class="form">
        <div class="input-group">
          <label>Email</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="your@email.com"
            required
          />
        </div>

        <div class="input-group">
          <label>Пароль</label>
          <div class="password-wrapper">
            <input
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="••••••••"
              required
            />
            <button 
              type="button" 
              class="toggle-password"
              @click="togglePassword"
            >
              {{ showPassword ? '🙈' : '👁️' }}
            </button>
          </div>
        </div>

        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Вход...' : 'Войти' }}
        </button>
      </form>

      <div class="back-link">
        <router-link to="/" class="back-btn">
          ← На главную
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const backgroundImage = ref('img/fon.png')
const loading = ref(false)
const showPassword = ref(false)

const form = ref({
  email: '',
  password: ''
})

const togglePassword = () => {
  showPassword.value = !showPassword.value
}

const getCookie = (name) => {
  const match = document.cookie.match(
    new RegExp('(^| )' + name + '=([^;]+)')
  )
  return match ? decodeURIComponent(match[2]) : null
}

const submitLogin = async () => {
  loading.value = true

  try {
    // 1. Получаем CSRF cookie
    await fetch('http://localhost:8000/sanctum/csrf-cookie', {
        credentials: 'include'
      })

    const xsrfToken = getCookie('XSRF-TOKEN')

const response = await fetch('http://localhost:8000/login', {
  method: 'POST',
  credentials: 'include',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-XSRF-TOKEN': xsrfToken // 🔥 ВОТ ЭТО КЛЮЧ
  },
  body: JSON.stringify({
    email: form.value.email,
    password: form.value.password
  })
})

    const result = await response.json()

    if (result.success) {
      alert('Добро пожаловать!')

      if (result.user.role === 1) {
        router.push('/admin')
      } else {
        router.push('/chats')
      }
    }

  } catch (e) {
    alert('Ошибка входа')
  } finally {
    loading.value = false
  }
}


</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html, body, #app {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
}

.bg-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -2;
  filter: brightness(0.82) contrast(1.08);
}

.glass-form {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  width: 90%;
  max-width: 460px;
  padding: 45px 40px;
  background: rgba(255, 255, 255, 0.14);
  backdrop-filter: blur(26px);
  border: 1px solid rgba(255, 255, 255, 0.35);
  border-radius: 32px;
  box-shadow: 0 30px 70px rgba(0, 0, 0, 0.35);
  color: white;
}

.title-block {
  text-align: center;
  margin-bottom: 40px;
}

.subtitle {
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #ffdeb8;
  margin-bottom: 8px;
}

.title {
  font-size: 48px;
  font-weight: 700;
  line-height: 1.05;
  margin-bottom: 12px;
}

.desc {
  font-size: 15px;
  color: rgba(255, 255, 255, 0.78);
}

.input-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

.input-group label {
  margin-bottom: 8px;
  font-size: 14px;
  color: rgba(255, 255, 255, 0.9);
}

.input-group input {
  width: 100%;
  padding: 15px 18px;
  background: rgba(255, 255, 255, 0.13);
  border: 1px solid rgba(255, 255, 255, 0.32);
  border-radius: 18px;
  color: white;
  font-size: 15px;
  outline: none;
  transition: all 0.3s ease;
}

.input-group input::placeholder {
  color: rgba(255, 255, 255, 0.65);
}

.input-group input:focus {
  border-color: #ff9f4d;
  background: rgba(255, 255, 255, 0.22);
  box-shadow: 0 0 0 4px rgba(255, 159, 77, 0.25);
}

.password-wrapper {
  position: relative;
  width: 100%;
}

.password-wrapper input {
  padding-right: 50px;
}

.toggle-password {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  cursor: pointer;
  font-size: 18px;
  color: rgba(255, 255, 255, 0.7);
}

.submit-btn {
  padding: 16px;
  width: 100%;
  background: rgba(255, 140, 40, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 160, 60, 0.6);
  color: white;
  font-size: 16px;
  font-weight: 600;
  border-radius: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.submit-btn:hover:not(:disabled) {
  background: rgba(255, 140, 40, 0.45);
  transform: translateY(-3px);
}

.submit-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.register-link {
  text-align: center;
  margin-top: 25px;
  font-size: 14px;
  color: rgba(255, 255, 255, 0.7);
}

.register-link a {
  color: #ffdeb8;
  text-decoration: none;
  font-weight: 500;
}

.register-link a:hover {
  color: #ff9f4d;
}

.back-link {
  text-align: center;
  margin-top: 20px;
}

.back-btn {
  display: inline-block;
  padding: 10px 20px;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 18px;
  color: white;
  text-decoration: none;
  font-size: 13px;
}

.back-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateX(-3px);
}

.corner {
  position: absolute;
  bottom: 40px;
  right: 40px;
  width: 58px;
  height: 58px;
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(14px);
  border: 1px solid rgba(255, 255, 255, 0.28);
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 30px;
  color: white;
  cursor: pointer;
}

@media (max-width: 768px) {
  .glass-form {
    padding: 35px 25px;
  }
  
  .title {
    font-size: 36px;
  }
  
  .corner {
    bottom: 20px;
    right: 20px;
    width: 45px;
    height: 45px;
    font-size: 24px;
  }
}
</style>
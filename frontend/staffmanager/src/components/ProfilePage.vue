<template>

  <div class="profile-page">
    <AppMenu />
    <div class="card">
      <h2>Профиль</h2>

      <div v-if="loading">Загрузка...</div>

      <form v-else @submit.prevent="save">

        <div class="field">
          <label>Логин</label>
          <input v-model="form.login" />
        </div>

        <div class="field">
          <label>Email</label>
          <input v-model="form.email" />
        </div>

        <div class="field">
          <label>Новый пароль</label>
          <input v-model="form.password" type="password" placeholder="оставь пустым если не менять" />
        </div>

        <div class="field">
          <label>Роль</label>
          <input :value="form.role === 1 ? 'Админ' : 'Пользователь'" disabled />
        </div>

        <button type="submit" class="btn">
          Сохранить
        </button>

      </form>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppMenu from './items/AppMenu.vue'

const loading = ref(true)

const form = ref({
  login: '',
  email: '',
  password: '',
  role: 0
})

// =====================
// GET PROFILE
// =====================
const fetchProfile = async () => {
  loading.value = true

  try {
    const res = await fetch('http://localhost:8000/api/profile', {
      credentials: 'include',
      headers: {
        Accept: 'application/json'
      }
    })

    if (!res.ok) {
      throw new Error('Unauthorized')
    }

    const json = await res.json()

    // 🔥 защита от undefined
    if (!json?.data) {
      throw new Error('No user data')
    }

    form.value.login = json.data.login
    form.value.email = json.data.email
    form.value.role = json.data.role

  } catch (e) {
    console.log('PROFILE ERROR:', e)

    // можно редиректнуть на login
    // router.push('/login')

  } finally {
    loading.value = false
  }
}

// =====================
// SAVE PROFILE
// =====================
const save = async () => {
  const res = await fetch('http://localhost:8000/api/profile', {
    method: 'PUT',
    credentials: 'include',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json'
    },
    body: JSON.stringify({
      login: form.value.login,
      email: form.value.email,
      password: form.value.password
    })
  })

  const json = await res.json()

  if (json.success) {
    alert('Сохранено!')
    form.value.password = ''
  }
}

onMounted(() => {
  fetchProfile()
})
</script>

<style scoped>
.profile-page {
  padding: 100px 20px;
  display: flex;
  justify-content: center;
}

.card {
  width: 420px;
  padding: 30px;
  border-radius: 20px;

  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(20px);
  color: white;
}

.field {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
}

input {
  padding: 10px;
  border-radius: 10px;
  border: none;
  outline: none;
}

.btn {
  width: 100%;
  padding: 12px;
  border-radius: 12px;

  background: rgba(255, 140, 40, 0.3);
  color: white;
  border: 1px solid rgba(255,160,60,0.5);

  cursor: pointer;
}
</style>
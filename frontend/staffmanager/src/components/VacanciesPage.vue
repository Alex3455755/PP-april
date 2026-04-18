<template>
  <div class="wrapper">
    <img
      :src="backgroundImage"
      alt="Background"
      class="bg-image"
    >

    <div class="container">
      <!-- Заголовок -->
      <div class="header-block">
        <p class="subtitle">VACANCIES</p>
        <h1 class="title">СПИСОК ВАКАНСИЙ</h1>
        <p class="desc">Актуальные предложения для вас</p>
      </div>

      <!-- Кнопка назад -->
      <div class="back-button">
        <button @click="goBack" class="back-btn">
          ← Назад к форме
        </button>
      </div>

      <!-- Список вакансий -->
      <div v-if="loading" class="loading">
        <div class="spinner"></div>
        <p>Загрузка вакансий...</p>
      </div>

      <div v-else-if="error" class="error">
        <p>{{ error }}</p>
        <button @click="fetchVacancies" class="retry-btn">Повторить</button>
      </div>

      <div v-else class="vacancies-list">
        <div
          v-for="vacancy in vacancies"
          :key="vacancy.id"
          class="vacancy-card"
        >
          <h3 class="vacancy-title">{{ vacancy.title }}</h3>
          
          <p class="vacancy-description">{{ vacancy.description }}</p>

          <div class="vacancy-details">
            <div class="detail-item">
              <span class="detail-label">Зарплата:</span>
              <span class="detail-value">{{ vacancy.salary }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Опыт:</span>
              <span class="detail-value">{{ vacancy.experience }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Навыки:</span>
              <span class="detail-value">{{ vacancy.skills }}</span>
            </div>
          </div>

          <div class="apply-link">
            <a href="#" @click.prevent="applyForVacancy(vacancy)" class="apply-btn">
              Отправить заявку на вакансию →
            </a>
          </div>
        </div>

        <!-- Если вакансий нет -->
        <div v-if="vacancies.length === 0" class="empty-state">
          <p>Пока нет ни одной вакансии</p>
          <button @click="goBack" class="submit-btn">Вернуться и создать</button>
        </div>
      </div>
    </div>

    <div class="corner">⟳</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const backgroundImage = ref('img/fon.png')
const vacancies = ref([])
const loading = ref(false)
const error = ref(null)

const API_URL = 'http://localhost:8000/api'

const fetchVacancies = async () => {
  loading.value = true
  error.value = null
  
  try {
    const response = await fetch(`${API_URL}/vacancies`,{
      credentials: 'include'
    })
    
    if (!response.ok) {
      throw new Error(`Ошибка HTTP: ${response.status}`)
    }
    
    const result = await response.json()
    
    if (result.success) {
      vacancies.value = result.data
    } else {
      vacancies.value = result.data || []
    }
  } catch (err) {
    console.error('Ошибка загрузки:', err)
    error.value = 'Не удалось загрузить вакансии. Проверьте соединение с сервером.'
  } finally {
    loading.value = false
  }
}

const applyForVacancy = (vacancy) => {
  // Переход на главную страницу с заполнением данных вакансии
  router.push({
    path: '/',
    query: {
      position: vacancy.title,
      vacancy_id: vacancy.id
    }
  })
}

const goBack = () => {
  router.push('/')
}

onMounted(() => {
  fetchVacancies()
})
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
  overflow-x: hidden;
  overflow-y: auto;
}

.wrapper {
  position: relative;
  min-height: 100vh;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
}

.bg-image {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -2;
  filter: brightness(0.82) contrast(1.08);
}

.container {
  position: relative;
  z-index: 10;
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 20px;
}

.header-block {
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
  font-size: 52px;
  font-weight: 700;
  line-height: 1.05;
  margin-bottom: 12px;
  color: white;
}

.desc {
  font-size: 16.5px;
  color: rgba(255, 255, 255, 0.78);
}

.back-button {
  margin-bottom: 30px;
}

.back-btn {
  padding: 12px 24px;
  background: rgba(255, 255, 255, 0.13);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.32);
  border-radius: 18px;
  color: white;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.back-btn:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateX(-3px);
}

.vacancies-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
  gap: 25px;
}

.vacancy-card {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(255, 255, 255, 0.25);
  border-radius: 24px;
  padding: 24px;
  transition: all 0.3s ease;
}

.vacancy-card:hover {
  transform: translateY(-5px);
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(255, 140, 40, 0.5);
}

.vacancy-title {
  font-size: 22px;
  font-weight: 600;
  color: white;
  margin: 0 0 15px 0;
  padding-bottom: 12px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.vacancy-description {
  color: rgba(255, 255, 255, 0.85);
  font-size: 14px;
  line-height: 1.5;
  margin-bottom: 18px;
}

.vacancy-details {
  background: rgba(0, 0, 0, 0.2);
  border-radius: 16px;
  padding: 12px;
  margin-bottom: 20px;
}

.detail-item {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.detail-item:last-child {
  border-bottom: none;
}

.detail-label {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.7);
  font-weight: 500;
}

.detail-value {
  font-size: 13px;
  color: white;
  text-align: right;
  max-width: 60%;
}

.apply-link {
  text-align: center;
  margin-top: 10px;
}

.apply-btn {
  display: inline-block;
  padding: 12px 24px;
  background: rgba(255, 140, 40, 0.25);
  border: 1px solid rgba(255, 160, 60, 0.6);
  border-radius: 18px;
  color: white;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.apply-btn:hover {
  background: rgba(255, 140, 40, 0.45);
  transform: translateY(-2px);
}

.loading,
.error,
.empty-state {
  text-align: center;
  padding: 60px 20px;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(16px);
  border-radius: 32px;
  color: white;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 4px solid rgba(255, 255, 255, 0.2);
  border-top-color: #ff9f4d;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 20px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error p {
  margin-bottom: 20px;
  color: #ff8a7a;
}

.retry-btn,
.submit-btn {
  padding: 12px 24px;
  background: rgba(255, 140, 40, 0.25);
  border: 1px solid rgba(255, 160, 60, 0.6);
  border-radius: 18px;
  color: white;
  cursor: pointer;
  font-size: 14px;
}

.retry-btn:hover,
.submit-btn:hover {
  background: rgba(255, 140, 40, 0.45);
}

.corner {
  position: fixed;
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
  transition: all 0.3s ease;
  z-index: 20;
}

.corner:hover {
  transform: rotate(180deg);
  background: rgba(255, 255, 255, 0.2);
}

@media (max-width: 768px) {
  .container {
    padding: 20px 15px;
  }
  
  .title {
    font-size: 36px;
  }
  
  .vacancies-list {
    grid-template-columns: 1fr;
  }
  
  .vacancy-card {
    padding: 18px;
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
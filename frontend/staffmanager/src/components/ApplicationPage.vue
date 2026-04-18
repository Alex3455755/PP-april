<template>

  <AppMenu />
  <div class="wrapper">
    <img :src="backgroundImage" alt="Background" class="bg-image">

    <div class="content">
      <div class="header">
        <h1 class="title">Заявки</h1>
        <p class="desc">Выберите вакансию, чтобы посмотреть заявки</p>
      </div>

      <!-- ВАКАНСИИ -->
      <div class="vacancies-grid">
        <div
          v-for="vacancy in vacancies"
          :key="vacancy.id"
          class="vacancy-card"
          :class="{ active: selectedVacancyId === vacancy.id }"
          @click="selectVacancy(vacancy.id)"
        >
          <h3>{{ vacancy.title }}</h3>
          <p class="company">{{ vacancy.company || 'Компания не указана' }}</p>

          <span class="count">
            Заявок:
            <strong>{{ getApplicationsCount(vacancy.id) }}</strong>
          </span>
        </div>
      </div>

      <!-- ЗАЯВКИ -->
      <div v-if="selectedVacancyId" class="applications-section">
        <h2 class="section-title">
          Заявки на:
          <span class="vacancy-name">{{ selectedVacancy?.title }}</span>
        </h2>

        <div class="applications-list">
          <div
            v-for="app in sortedApplications"
            :key="app.id"
            class="application-card"
          >
            <div class="applicant-info">
              <h4>{{ app.name }}</h4>
              <p class="email">{{ app.email }}</p>
            </div>

            <div class="details">
              <div class="detail-item">
                <span class="label">Возраст </span>
                <span class="value">{{ app.age }}  лет</span>
              </div>

              <div class="detail-item">
                <span class="label">Опыт </span>
                <span class="value">{{ app.experience }}</span>
              </div>

              <div class="detail-item">
                <span class="label">Образование </span>
                <span class="value">{{ app.education }}</span>
              </div>
            </div>

            <div class="rating">
              <span class="label">Рейтинг</span>
              <span class="rate-value">
                {{ (app.rate || 0).toFixed(2) }}
              </span>
            </div>

            <div class="date">
              {{ new Date(app.created_at).toLocaleDateString('ru-RU') }}
            </div>

            <div class="actions">
                <button class="reject" @click="reject(app.id)">Отказ</button>
                <button class="invite" @click="invite(app.id)">Пригласить</button>
            </div>
          </div>

          <div v-if="sortedApplications.length === 0" class="no-applications">
            Нет заявок на эту вакансию
          </div>
        </div>
      </div>

      <div v-else class="no-selection">
        Выберите вакансию
      </div>
    </div>

    <div class="corner">⟳</div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

import AppMenu from './items/AppMenu.vue'

const backgroundImage = ref('img/fon.png')

const vacancies = ref([])
const applications = ref([])

const selectedVacancyId = ref(null)

const selectVacancy = (id) => {
  selectedVacancyId.value = id
}

const reject = async (id) => {
  await fetch(`http://loclahost:8000/api/applications/${id}/reject`, {
    method: 'POST'
  })

  alert('Письмо об отказе отправлено')
}

const invite = async (id) => {
  await fetch(`http://localhost:8000/api/applications/${id}/invite`, {
    credentials: 'include',
    method: 'POST'
  })

  alert('Пользователь создан и приглашение отправлено')
}

/* -----------------------------
   ЗАГРУЗКА ДАННЫХ
------------------------------*/
onMounted(async () => {
  const vacRes = await fetch('http://localhost:8000/api/vacancies',{credentials: 'include'})
  const appRes = await fetch('http://localhost:8000/api/requests',{credentials: 'include'})

  const vacData = await vacRes.json()
  const appData = await appRes.json()

  console.log('VAC:', vacData)
  console.log('APP:', appData)

  vacancies.value = Array.isArray(vacData) ? vacData : vacData.data
  applications.value = Array.isArray(appData)
    ? appData
    : (appData.data || [])
})

/* -----------------------------
   ВЫБРАННАЯ ВАКАНСИЯ
------------------------------*/
const selectedVacancy = computed(() =>
  vacancies.value.find(v => v.id === selectedVacancyId.value)
)

/* -----------------------------
   ЗАЯВКИ ПО ВАКАНСИИ
------------------------------*/
const sortedApplications = computed(() => {
  if (!selectedVacancyId.value) return []

  return applications.value
    .filter(app =>
      Number(app.vacancie_id) === Number(selectedVacancyId.value)
    )
    .sort((a, b) => (b.rate || 0) - (a.rate || 0))
})

/* -----------------------------
   КОЛИЧЕСТВО ЗАЯВОК
------------------------------*/
const getApplicationsCount = (vacancyId) => {
  return applications.value.filter(app =>
    Number(app.vacancie_id) === Number(vacancyId)
  ).length
}
</script>

<style scoped>
.wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  overflow: hidden;
  color: white;
}
.menu {
  z-index: 9999;
}

.bg-image {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -2;
  filter: brightness(0.85);
}

.content {
  padding: 40px 60px;
  height: 100%;
  overflow-y: auto;
}

.actions {
  display: flex;
  gap: 10px;
  margin-left: 20px;
}

.actions button {
  padding: 10px 14px;
  border-radius: 12px;
  border: none;
  cursor: pointer;
  font-weight: 600;
  transition: 0.2s;
}

.reject {
  background: rgba(255, 80, 80, 0.2);
  color: #ff6b6b;
}

.reject:hover {
  background: rgba(255, 80, 80, 0.35);
}

.invite {
  background: rgba(80, 255, 160, 0.15);
  color: #4ef0a5;
}

.invite:hover {
  background: rgba(80, 255, 160, 0.3);
}

.header {
  text-align: center;
  margin-bottom: 40px;
}

.title {
  font-size: 44px;
  margin-bottom: 10px;
}

.vacancies-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.vacancy-card {
  background: rgba(255,255,255,0.12);
  padding: 20px;
  border-radius: 18px;
  cursor: pointer;
  transition: 0.3s;
}

.vacancy-card:hover {
  transform: translateY(-5px);
}

.vacancy-card.active {
  background: rgba(255, 159, 77, 0.2);
  border: 1px solid #ff9f4d;
}

.applications-section {
  background: rgba(255,255,255,0.1);
  padding: 25px;
  border-radius: 20px;
}

.application-card {
  display: flex;
  justify-content: space-between;
  background: rgba(255,255,255,0.08);
  padding: 18px;
  border-radius: 14px;
  margin-bottom: 12px;
}

.rate-value {
  font-size: 24px;
  color: #ff9f4d;
  font-weight: bold;
}

.no-selection,
.no-applications {
  text-align: center;
  padding: 40px;
  opacity: 0.7;
}

.wrapper {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  letter-spacing: 0.2px;
}

.title {
  font-size: 52px;
  font-weight: 800;
  letter-spacing: -1px;
}

.desc {
  font-size: 16px;
  opacity: 0.75;
}

.application-card {
  display: flex;
  justify-content: space-between;
  gap: 40px;

  background: rgba(255, 255, 255, 0.08);
  padding: 28px 32px;   /* 🔥 больше воздуха */
  border-radius: 22px;
  margin-bottom: 18px;

  border: 1px solid rgba(255, 255, 255, 0.15);
}

.details {
  display: flex;
  gap: 50px;
  flex: 1;
}

.detail-item {
  min-width: 90px;
  text-align: left;
}

.value {
  font-size: 15px;
  font-weight: 600;
}

.rating {
  min-width: 90px;
  text-align: center;
  padding: 10px 14px;
  border-radius: 14px;

  background: rgba(255, 159, 77, 0.12);
  border: 1px solid rgba(255, 159, 77, 0.35);

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.rate-value {
  font-size: 30px;
  font-weight: 800;
  color: #ffb36b;
  text-shadow: 0 0 10px rgba(255, 159, 77, 0.25);
}

.application-card {
  transition: all 0.25s ease;
}

.application-card:hover {
  transform: translateY(-4px);
  background: rgba(255, 255, 255, 0.12);
}
</style>
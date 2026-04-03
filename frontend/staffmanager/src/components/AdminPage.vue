<template>
  <div class="wrapper">
    <!-- Фон -->
    <img
      :src="backgroundImage"
      alt="Background"
      class="bg-image"
    >

    <div class="content">
      <!-- Заголовок страницы -->
      <div class="page-header">
        <h1>Актуальные вакансии</h1>
        <p class="subtitle">НОВОМЕТ — Отдел кадров</p>
      </div>

      <!-- Список вакансий -->
      <div class="vacancies-grid">
        <div v-for="vacancy in vacancies" :key="vacancy.id" class="vacancy-card">
          <div class="vacancy-header">
            <h3>{{ vacancy.title }}</h3>
            <span class="department">{{ vacancy.department }}</span>
          </div>
          
          <div class="info">
            <p><strong>Зарплата:</strong> {{ vacancy.salary }}</p>
            <p><strong>Опыт:</strong> {{ vacancy.experience }}</p>
            <p><strong>Формат:</strong> {{ vacancy.format }}</p>
          </div>

          <div class="vacancy-footer">
            <span class="applications">
              {{ vacancy.applications }} заявок
            </span>
            <button @click="viewApplications(vacancy)" class="view-btn">
              Просмотреть заявки
            </button>
          </div>
        </div>
      </div>

      <!-- Кнопка возврата -->
      <div class="back-button">
        <button @click="$router.push('/')" class="back-btn">
          ← Вернуться на главную страницу
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const backgroundImage = ref('img/fon.png') // тот же фон, что и на первой странице

const vacancies = ref([
  {
    id: 1,
    title: "Руководитель отдела продаж",
    department: "Продажи",
    salary: "от 150 000 ₽",
    experience: "от 3 лет",
    format: "Офис / Гибрид",
    applications: 12
  },
  {
    id: 2,
    title: "Менеджер по продажам B2B",
    department: "Продажи",
    salary: "от 80 000 ₽ + %",
    experience: "от 1 года",
    format: "Офис",
    applications: 28
  },
  {
    id: 3,
    title: "Специалист по маркетингу",
    department: "Маркетинг",
    salary: "от 90 000 ₽",
    experience: "от 2 лет",
    format: "Гибрид",
    applications: 7
  },
  {
    id: 4,
    title: "HR-менеджер",
    department: "Кадры",
    salary: "от 100 000 ₽",
    experience: "от 2 лет",
    format: "Офис",
    applications: 5
  },
  {
    id: 5,
    title: "Ведущий инженер",
    department: "Производство",
    salary: "от 130 000 ₽",
    experience: "от 5 лет",
    format: "Офис",
    applications: 9
  }
])

const viewApplications = (vacancy) => {
  alert(`Открываем заявки по вакансии: ${vacancy.title}\n\n(Здесь будет таблица с заявками)`)
  // В будущем можно открыть модальное окно или перейти на другую страницу
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
  filter: brightness(0.75) contrast(1.1);
}

.content {
  position: relative;
  z-index: 10;
  padding: 40px 20px;
  max-width: 1200px;
  margin: 0 auto;
  height: 100vh;
  overflow-y: auto;
}

.page-header {
  text-align: center;
  margin-bottom: 50px;
  color: white;
}

.page-header h1 {
  font-size: 48px;
  font-weight: 700;
  margin-bottom: 8px;
}

.subtitle {
  font-size: 18px;
  color: rgba(255, 255, 255, 0.8);
  font-weight: 500;
}

/* Сетка вакансий */
.vacancies-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
  gap: 24px;
}

.vacancy-card {
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 24px;
  padding: 28px;
  color: white;
  transition: all 0.3s ease;
}

.vacancy-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.vacancy-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 20px;
}

.vacancy-header h3 {
  font-size: 22px;
  font-weight: 600;
  line-height: 1.3;
}

.department {
  background: rgba(255, 159, 77, 0.25);
  color: #ffcf9f;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
}

.info p {
  margin-bottom: 10px;
  opacity: 0.9;
}

.info strong {
  color: #ffdeb8;
}

/* Нижняя часть карточки */
.vacancy-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 24px;
  padding-top: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.15);
}

.applications {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.7);
}

.view-btn {
  background: rgba(255, 140, 40, 0.3);
  border: 1px solid rgba(255, 160, 60, 0.7);
  color: white;
  padding: 10px 22px;
  border-radius: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.view-btn:hover {
  background: rgba(255, 140, 40, 0.5);
  transform: translateY(-2px);
}

/* Кнопка возврата */
.back-button {
  text-align: center;
  margin-top: 60px;
}

.back-btn {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.4);
  color: white;
  padding: 14px 32px;
  border-radius: 18px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s;
}

.back-btn:hover {
  background: rgba(255, 255, 255, 0.25);
}

/* Стили для полосы прокрутки (современные браузеры) */
.content {
  position: relative;
  z-index: 10;
  padding: 40px 20px;
  max-width: 1200px;
  margin: 0 auto;
  height: 100vh;
  overflow-y: auto; /* Прокрутка по вертикали */
  scrollbar-width: thin;           /* Firefox */
  scrollbar-color: rgba(255,140,40,0.6) rgba(255,255,255,0.1); /* Firefox */
}

/* Webkit (Chrome, Edge, Safari) */
.content::-webkit-scrollbar {
  width: 10px; /* ширина полосы прокрутки */
}

.content::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05); /* фон дорожки */
  border-radius: 10px;
}

.content::-webkit-scrollbar-thumb {
  background-color: rgba(255, 140, 40, 0.6); /* цвет «ползунка» */
  border-radius: 10px;
  border: 2px solid rgba(255, 255, 255, 0.1); /* отступ внутри */
}

.content::-webkit-scrollbar-thumb:hover {
  background-color: rgba(255, 140, 40, 0.8);
}
</style>
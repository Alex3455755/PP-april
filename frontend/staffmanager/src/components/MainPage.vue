<template>
  <div class="wrapper">

    <AppMenu />
    <img
      :src="backgroundImage"
      alt="Background"
      class="bg-image"
    >

    <div class="glass-form">
      <div class="title-block">
        <h1 class="title">НОВОМЕТ</h1>
        <p class="desc">Отправьте заявку на интересующую вас вакансию</p>
      </div>

      <form @submit.prevent="submitForm" class="form">
        <div class="input-group">
          <label>ФИО</label>
          <input
            v-model="form.fullName"
            type="text"
            placeholder="Иванов Иван Иванович"
            required
          />
        </div>

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
          <label>Возраст</label>
          <input
            v-model="form.age"
            type="number"
            placeholder="25"
            required
          />
        </div>

        <div class="input-group">
          <label>Опыт работы (лет)</label>
          <input
            v-model="form.experience"
            type="number"
            placeholder="3"
            required
          />
        </div>

        <div class="input-group">
          <label>Образование</label>
          <div class="select-wrapper">
            <select v-model="form.education" required class="custom-select">
              <option value="" disabled selected>Выберите образование</option>
              <option value="Среднее общее">Среднее общее</option>
              <option value="Среднее профессиональное">Среднее профессиональное</option>
              <option value="Высшее - Бакалавр">Высшее - Бакалавр</option>
              <option value="Высшее - Магистр">Высшее - Магистр</option>
              <option value="Высшее - Специалист">Высшее - Специалист</option>
              <option value="Ученая степень">Ученая степень</option>
            </select>
          </div>
        </div>

        <div class="input-group">
          <label>Учебное заведение (колледж/вуз)</label>
          <div class="select-wrapper">
            <select v-model="form.college_id" required class="custom-select">
              <option value="" disabled selected>Выберите учебное заведение</option>
              <option v-for="college in colleges" :key="college.id" :value="college.id">
                {{ college.name }}
              </option>
            </select>
          </div>
        </div>

        <div class="input-group">
          <label>Должность</label>
          <div class="select-wrapper">
            <select v-model="form.vacancie_id" required class="custom-select">
              <option value="" disabled selected>Выберите должность</option>
              <option v-for="vacancy in vacancies" :key="vacancy.id" :value="vacancy.id">
                {{ vacancy.title }}
              </option>
            </select>
          </div>
        </div>

        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Отправка...' : 'Отправить заявку' }}
        </button>
      </form>

      <div class="employee-link">
        <a href="#" @click.prevent="goToEmployeePage">Для сотрудников компании</a>
      </div>
      
      <div class="vacancies-link">
        <router-link to="/" class="vacancies-btn">
          Смотреть все вакансии
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import AppMenu from './items/AppMenu.vue'

const route = useRoute()

const backgroundImage = ref('img/fon.png')
const loading = ref(false)
const colleges = ref([])
const vacancies = ref([])

const form = ref({
  name: '',
  email: '',
  age: '',
  experience: '',
  education: '',
  college_id: '',
  vacancie_id: ''
})

const API_URL = 'http://localhost:8000/api'

// Загрузка списка колледжей
const fetchColleges = async () => {
  try {
    const response = await fetch(`${API_URL}/colleges`,{
      credentials: 'include'
    })
    const result = await response.json()
    if (result.success) {
      colleges.value = result.data
    }
  } catch (error) {
    console.error('Ошибка загрузки колледжей:', error)
  }
}

// Загрузка списка вакансий
const fetchVacancies = async () => {
  try {
    const response = await fetch(`${API_URL}/vacancies`,{
      credentials: 'include'
    })
    const result = await response.json()
    if (result.success) {
      vacancies.value = result.data
    }
  } catch (error) {
    console.error('Ошибка загрузки вакансий:', error)
  }
}

// Если перешли с страницы вакансий, подставляем вакансию
onMounted(() => {
  fetchColleges()
  fetchVacancies()
  
  if (route.query.vacancy_id) {
    form.value.vacancie_id = parseInt(route.query.vacancy_id)
  }
})

const submitForm = async () => {
  if (!form.value.fullName || !form.value.email || !form.value.age || 
      !form.value.experience || !form.value.education || 
      !form.value.college_id || !form.value.vacancie_id) {
    alert('Пожалуйста, заполните все поля')
    return
  }
  
  loading.value = true
  
  try {
    const requestData = {
      name: form.value.fullName,
      email: form.value.email,
      age: parseInt(form.value.age),
      experience: parseInt(form.value.experience),
      education: form.value.education,
      college_id: parseInt(form.value.college_id),
      vacancie_id: parseInt(form.value.vacancie_id)
    }
    
    const response = await fetch(`${API_URL}/requests`, {
      credentials: 'include',
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(requestData)
    })
    
    const result = await response.json()
    
    if (result.success) {
      alert('Заявка успешно отправлена!')
      form.value = {
        fullName: '',
        email: '',
        age: '',
        experience: '',
        education: '',
        college_id: '',
        vacancie_id: ''
      }
    } else {
      alert('Ошибка при отправке: ' + (result.message || 'Неизвестная ошибка'))
    }
  } catch (error) {
    console.error('Ошибка:', error)
    alert('Не удалось отправить заявку. Проверьте соединение с сервером.')
  } finally {
    loading.value = false
  }
}

const goToEmployeePage = () => {
  document.location = 'login'
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
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
  padding: 40px 35px;
  background: rgba(255, 255, 255, 0.14);
  backdrop-filter: blur(26px);
  -webkit-backdrop-filter: blur(26px);
  border: 1px solid rgba(255, 255, 255, 0.35);
  border-radius: 32px;
  box-shadow: 0 30px 70px rgba(0, 0, 0, 0.35);
  color: white;
}

.glass-form::-webkit-scrollbar {
  width: 5px;
}

.glass-form::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

.glass-form::-webkit-scrollbar-thumb {
  background: rgba(255, 140, 40, 0.5);
  border-radius: 10px;
}

.title-block {
  text-align: center;
  margin-bottom: 35px;
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
  max-width: 360px;
  margin: 0 auto;
}

.input-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 18px;
}

.input-group label {
  margin-bottom: 8px;
  font-size: 14px;
  color: rgba(255, 255, 255, 0.9);
}

.input-group input,
.custom-select {
  width: 100%;
  padding: 14px 18px;
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

.input-group input:focus,
.custom-select:focus {
  border-color: #ff9f4d;
  background: rgba(255, 255, 255, 0.22);
  box-shadow: 0 0 0 4px rgba(255, 159, 77, 0.25);
}

.select-wrapper {
  position: relative;
}

.custom-select {
  appearance: none;
  padding-right: 50px;
  cursor: pointer;
}

.custom-select option {
  background: #1a1a2e;
  color: #ffffff;
  padding: 12px 16px;
}

.select-wrapper::after {
  content: '';
  position: absolute;
  right: 22px;
  top: 50%;
  transform: translateY(-50%);
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 8px solid rgba(255, 255, 255, 0.85);
  pointer-events: none;
}

.submit-btn {
  margin-top: 10px;
  padding: 15px;
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

.employee-link {
  text-align: center;
  margin-top: 25px;
  font-size: 14px;
}

.employee-link a {
  color: rgba(255, 255, 255, 0.75);
  text-decoration: none;
  transition: color 0.3s ease;
}

.employee-link a:hover {
  color: white;
}

.vacancies-link {
  text-align: center;
  margin-top: 15px;
}

.vacancies-btn {
  display: inline-block;
  padding: 10px 20px;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 18px;
  color: white;
  text-decoration: none;
  font-size: 13px;
  transition: all 0.3s ease;
}

.vacancies-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
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
  transition: all 0.3s ease;
}

.corner:hover {
  transform: rotate(180deg);
  background: rgba(255, 255, 255, 0.2);
}

@media (max-width: 768px) {
  .glass-form {
    padding: 30px 25px;
    max-height: 95vh;
  }
  
  .title {
    font-size: 36px;
  }
  
  .subtitle {
    font-size: 11px;
  }
  
  .desc {
    font-size: 13px;
  }
  
  .input-group input,
  .custom-select {
    padding: 12px 15px;
    font-size: 14px;
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
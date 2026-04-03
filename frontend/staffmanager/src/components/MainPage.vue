<template>
  <div class="wrapper">
    <img
      :src="backgroundImage"
      alt="Background"
      class="bg-image"
    >

    <div class="glass-form">
      <div class="title-block">
        <p class="subtitle">3D GLASSMORPHISM</p>
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
          <label>Должность</label>
          <div class="select-wrapper">
            <select v-model="form.position" required class="custom-select">
              <option value="" disabled selected>Выберите должность</option>
              <option value="Руководитель отдела продаж">Руководитель отдела продаж</option>
              <option value="Менеджер по продажам">Менеджер по продажам</option>
              <option value="Специалист по маркетингу">Специалист по маркетингу</option>
              <option value="Финансовый директор">Финансовый директор</option>
              <option value="Бухгалтер">Бухгалтер</option>
              <option value="HR-менеджер">HR-менеджер</option>
              <option value="Программист">Программист</option>
              <option value="Инженер">Инженер</option>
              <option value="Логист">Логист</option>
              <option value="Другое">Другое</option>
            </select>
          </div>
        </div>

        <button type="submit" class="submit-btn">
          Отправить заявку
        </button>
      </form>

      <div class="employee-link">
        <a href="#" @click.prevent="goToEmployeePage">Для сотрудников компании</a>
      </div>
    </div>

    <div class="corner">⟳</div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const backgroundImage = ref('img/fon.png')

const form = ref({
  fullName: '',
  email: '',
  position: ''
})

const submitForm = () => {
  if (!form.value.fullName || !form.value.email || !form.value.position) {
    alert('Пожалуйста, заполните все поля')
    return
  }
  alert('✅ Заявка успешно отправлена!')
  console.log('Отправлено:', form.value)
  form.value = { fullName: '', email: '', position: '' }
}

const goToEmployeePage = () => {
  document.location = 'staff';
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
  padding: 50px 45px;
  background: rgba(255, 255, 255, 0.14);
  backdrop-filter: blur(26px);
  -webkit-backdrop-filter: blur(26px);
  border: 1px solid rgba(255, 255, 255, 0.35);
  border-radius: 32px;
  box-shadow: 0 30px 70px rgba(0, 0, 0, 0.35);
  color: white;
}

.title-block {
  text-align: center;
  margin-bottom: 42px;
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
}

.desc {
  font-size: 16.5px;
  color: rgba(255, 255, 255, 0.78);
  max-width: 360px;
  margin: 0 auto;
}

/* Поля ввода */
.input-group {
  display: flex;
  flex-direction: column;
}

.input-group label {
  margin-bottom: 8px;
  font-size: 14.5px;
  color: rgba(255, 255, 255, 0.9);
}

.input-group input,
.custom-select {
  width: 100%;
  padding: 16px 20px;
  background: rgba(255, 255, 255, 0.13);
  border: 1px solid rgba(255, 255, 255, 0.32);
  border-radius: 18px;
  color: white;
  font-size: 16px;
  outline: none;
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

/* Селект - исправленная версия */
.select-wrapper {
  position: relative;
}

.custom-select {
  appearance: none;
  padding-right: 50px;
  cursor: pointer;
}

.custom-select option {
  background: #1a1a2e;        /* Тёмный фон для опций */
  color: #ffffff;
  padding: 12px 16px;
}

/* Стрелка */
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

/* Кнопка */
.submit-btn {
  margin-top: 15px;
  padding: 17px;
  width: 100%;
  background: rgba(255, 140, 40, 0.25);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 160, 60, 0.6);
  color: white;
  font-size: 17.5px;
  font-weight: 600;
  border-radius: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.submit-btn:hover {
  background: rgba(255, 140, 40, 0.45);
  transform: translateY(-3px);
}

/* Ссылка */
.employee-link {
  text-align: center;
  margin-top: 32px;
  font-size: 14.5px;
}

.employee-link a {
  color: rgba(255, 255, 255, 0.75);
  text-decoration: none;
}

.employee-link a:hover {
  color: white;
}

/* Уголок */
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
}
</style>
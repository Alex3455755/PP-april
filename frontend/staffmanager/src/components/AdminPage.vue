<template>

  <AppMenu />
  <div class="wrapper">

    <!-- Фон -->
    <img :src="backgroundImage" class="bg-image" />

    <div class="content">

      <!-- Заголовок -->
      <div class="page-header">
        <h1>Актуальные вакансии</h1>
        <p class="subtitle">НОВОМЕТ — Отдел кадров</p>
      </div>

      <!-- Список вакансий -->
      <div class="vacancies-grid">

        <div v-for="vacancy in vacancies" :key="vacancy.id" class="vacancy-card">

          <div class="vacancy-header">
            <h3>{{ vacancy.title }}</h3>
            <span class="department">Вакансия</span>
          </div>

          <div class="info">
            <p><strong>Зарплата:</strong> {{ vacancy.salary }}</p>
            <p><strong>Опыт:</strong> {{ vacancy.experience }}</p>
            <p><strong>Навыки:</strong> {{ vacancy.skills }}</p>
          </div>

          <div class="vacancy-footer">

            <button @click="editVacancy(vacancy)" class="view-btn">
              Редактировать
            </button>

            <button @click="deleteVacancy(vacancy.id)" class="delete-btn">
              Удалить
            </button>

          </div>
          

        </div>

       

      </div>
       <div class="top-actions">
          <button class="add-btn" @click="openCreateModal">
            + Создать вакансию
          </button>
</div>

    </div>

    <!-- MODAL -->
    <!-- MODAL -->
<div v-if="editModal" class="modal-overlay">
  <div class="glass-modal">

    <div class="modal-header">
      <h2>Редактирование вакансии</h2>
      <p>Измените данные вакансии</p>
    </div>

    <div class="form">

      <div class="input-group">
        <label>Название</label>
        <input v-model="editForm.title" type="text" />
      </div>

      <div class="input-group">
        <label>Описание</label>
        <textarea v-model="editForm.description"></textarea>
      </div>

      <div class="input-group">
        <label>Зарплата</label>
        <input v-model="editForm.salary" type="text" />
      </div>

      <div class="input-group">
        <label>Опыт</label>
        <input v-model="editForm.experience" type="text" />
      </div>

      <div class="input-group">
        <label>Навыки</label>
        <input v-model="editForm.skills" type="text" />
      </div>

      <div class="modal-actions">
        <button class="save-btn" @click="updateVacancy">
          Сохранить
        </button>

        <button class="cancel-btn" @click="editModal = false">
          Отмена
        </button>
      </div>

    </div>
  </div>
</div>


<!-- CREATE MODAL -->
<div v-if="createModal" class="modal-overlay">
  <div class="glass-modal">

    <div class="modal-header">
      <h2>Создание вакансии</h2>
      <p>Добавьте новую вакансию</p>
    </div>

    <div class="form">

      <div class="input-group">
        <label>Название</label>
        <input v-model="createForm.title" type="text" />
      </div>

      <div class="input-group">
        <label>Описание</label>
        <textarea v-model="createForm.description"></textarea>
      </div>

      <div class="input-group">
        <label>Зарплата</label>
        <input v-model="createForm.salary" type="text" />
      </div>

      <div class="input-group">
        <label>Опыт</label>
        <input v-model="createForm.experience" type="text" />
      </div>

      <div class="input-group">
        <label>Навыки</label>
        <input v-model="createForm.skills" type="text" />
      </div>

      <div class="modal-actions">
        <button class="save-btn" @click="storeVacancy">
          Создать
        </button>

        <button class="cancel-btn" @click="createModal = false">
          Отмена
        </button>
      </div>

    </div>
  </div>
</div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppMenu from './items/AppMenu.vue'


const createModal = ref(false)

const createForm = ref({
  title: '',
  description: '',
  salary: '',
  experience: '',
  skills: ''
})

const openCreateModal = () => {
  createForm.value = {
    title: '',
    description: '',
    salary: '',
    experience: '',
    skills: ''
  }
  createModal.value = true
}

const storeVacancy = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/vacancies', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(createForm.value)
    })

    if (!res.ok) throw new Error('Ошибка создания')

    createModal.value = false
    await fetchVacancies()

  } catch (e) {
    console.error('Ошибка создания вакансии:', e)
  }
}

const backgroundImage = ref('img/fon.png')

const vacancies = ref([])

const editModal = ref(false)

const editForm = ref({
  id: null,
  title: '',
  description: '',
  salary: '',
  experience: '',
  skills: ''
})

/* ------------------ ЗАГРУЗКА ------------------ */
const fetchVacancies = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/vacancies',{
      credentials: 'include'
    })
    vacancies.value = (await res.json()).data

    console.log(vacancies.value);
  } catch (e) {
    console.error('Ошибка загрузки вакансий:', e)
  }
}

/* ------------------ ОТКРЫТЬ РЕДАКТОР ------------------ */
const editVacancy = (vacancy) => {
  editForm.value = { ...vacancy }
  editModal.value = true
}

/* ------------------ ОБНОВЛЕНИЕ ------------------ */
const updateVacancy = async () => {
  try {
    const res = await fetch(`http://localhost:8000/api/vacancies/${editForm.value.id}`, {
      credentials: 'include',
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(editForm.value)
    })

    if (!res.ok) throw new Error('Ошибка обновления')

    editModal.value = false
    await fetchVacancies()

  } catch (e) {
    console.error('Ошибка обновления:', e)
  }
}

onMounted(() => {
  fetchVacancies()
})

const deleteVacancy = async (id) => {
  if (!confirm('Ты точно хочешь удалить вакансию?')) return

  try {
    const res = await fetch(`http://localhost:8000/api/vacancies/${id}`, {
      credentials: 'include',
      method: 'DELETE',
      headers: {
        'Accept': 'application/json'
      }
    })

    if (!res.ok) throw new Error('Ошибка удаления')

    // обновляем список
    await fetchVacancies()

  } catch (e) {
    console.error('Ошибка удаления вакансии:', e)
  }
}
</script>

<style scoped>


.top-actions {
  margin-bottom: 20px;
  display: flex;
  justify-content: flex-end;
}

.add-btn {
  padding: 12px 18px;
  border-radius: 16px;

  background: rgba(80, 255, 160, 0.12);
  border: 1px solid rgba(80, 255, 160, 0.4);

  color: #4ef0a5;
  font-weight: 600;

  cursor: pointer;
  transition: 0.3s;
}

.add-btn:hover {
  background: rgba(80, 255, 160, 0.25);
  transform: translateY(-2px);
}


.modal {
  position: fixed;
  inset: 0;
  z-index: 99999;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(0,0,0,0.6);
}

.modal-content {
  position: relative;
  z-index: 100000;
}
.wrapper {
  position: fixed;
  inset: 0;
  width: 100vw;
  height: 100vh;
  overflow: hidden;

  font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
  color: white;
}

.view-btn {
  padding: 10px 16px;
  border-radius: 12px;
  border: 1px solid rgba(255, 159, 77, 0.5);
  background: rgba(255, 159, 77, 0.15);
  color: #ffb36b;
  font-weight: 600;
  cursor: pointer;
  transition: 0.2s;
}

.view-btn:hover {
  background: rgba(255, 159, 77, 0.3);
  transform: translateY(-2px);
}

/* ФОН */
.bg-image {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -2;
  filter: brightness(0.72) contrast(1.1);
}

/* СКРОЛЛ */
.content {
  position: relative;
  z-index: 10;
  padding: 50px 60px;
  height: 100%;
  overflow-y: auto;
}

/* HEADER */
.header {
  text-align: center;
  margin-bottom: 40px;
}

.title {
  font-size: 56px;
  font-weight: 800;
  letter-spacing: -1px;
  margin-bottom: 10px;
}

.desc {
  font-size: 16px;
  opacity: 0.75;
}

/* ВАКАНСИИ */
.vacancies-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.vacancy-card {
  background: rgba(255, 255, 255, 0.10);
  backdrop-filter: blur(18px);

  border: 1px solid rgba(255, 255, 255, 0.18);
  border-radius: 20px;

  padding: 22px;
  cursor: pointer;

  transition: all 0.25s ease;
}

.vacancy-card:hover {
  transform: translateY(-6px);
  background: rgba(255, 255, 255, 0.14);
  box-shadow: 0 18px 40px rgba(0, 0, 0, 0.25);
}

.vacancy-card.active {
  border: 1px solid rgba(255, 159, 77, 0.7);
  background: rgba(255, 159, 77, 0.12);
}

.vacancy-card h3 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 6px;
}

.company {
  opacity: 0.7;
  font-size: 13px;
}

.count {
  display: inline-block;
  margin-top: 12px;
  font-size: 13px;
  opacity: 0.8;
}

.count strong {
  color: #ffb36b;
}

/* СЕКЦИЯ ЗАЯВОК */
.applications-section {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(20px);

  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 24px;

  padding: 28px;
}

/* ЗАГОЛОВОК */
.section-title {
  font-size: 22px;
  margin-bottom: 20px;
}

.vacancy-name {
  color: #ffb36b;
  font-weight: 700;
}

/* КАРТОЧКА ЗАЯВКИ */
.application-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 30px;

  padding: 24px 26px;
  margin-bottom: 14px;

  border-radius: 18px;

  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.12);

  transition: 0.25s ease;
}

.application-card:hover {
  transform: translateY(-4px);
  background: rgba(255, 255, 255, 0.10);
}

/* ЛЕВАЯ ЧАСТЬ */
.applicant-info h4 {
  font-size: 16px;
  font-weight: 600;
}

.email {
  font-size: 13px;
  opacity: 0.7;
}

/* ДЕТАЛИ */
.details {
  display: flex;
  gap: 40px;
  flex: 1;
}

.detail-item {
  min-width: 90px;
}

.label {
  font-size: 12px;
  opacity: 0.6;
}

.value {
  font-size: 14px;
  font-weight: 600;
}

/* РЕЙТИНГ */
.rating {
  min-width: 100px;
  text-align: center;

  padding: 10px 14px;
  border-radius: 14px;

  background: rgba(255, 159, 77, 0.12);
  border: 1px solid rgba(255, 159, 77, 0.3);
}

.rate-value {
  font-size: 26px;
  font-weight: 800;
  color: #ffb36b;
}

/* ДАТА */
.date {
  font-size: 12px;
  opacity: 0.6;
  min-width: 90px;
}

/* КНОПКИ */
.actions {
  display: flex;
  gap: 10px;
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
  background: rgba(255, 80, 80, 0.15);
  color: #ff6b6b;
}

.reject:hover {
  background: rgba(255, 80, 80, 0.30);
}

.invite {
  background: rgba(80, 255, 160, 0.12);
  color: #4ef0a5;
}

.invite:hover {
  background: rgba(80, 255, 160, 0.25);
}

/* ПУСТЫЕ СОСТОЯНИЯ */
.no-selection,
.no-applications {
  text-align: center;
  padding: 60px;
  opacity: 0.6;
}

/* КОРNER */
.corner {
  position: absolute;
  right: 20px;
  bottom: 20px;

  width: 40px;
  height: 40px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 12px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.15);
  backdrop-filter: blur(10px);
}
.menu {
  z-index: 9999;
}


.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  backdrop-filter: blur(10px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99999;
}

.glass-modal {
  width: 90%;
  max-width: 520px;

  padding: 35px;
  border-radius: 28px;

  background: rgba(255, 255, 255, 0.14);
  backdrop-filter: blur(26px);
  -webkit-backdrop-filter: blur(26px);

  border: 1px solid rgba(255, 255, 255, 0.35);

  box-shadow: 0 30px 70px rgba(0, 0, 0, 0.35);
  color: white;

  animation: pop 0.25s ease;
}

@keyframes pop {
  from {
    transform: scale(0.9);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}

.modal-header {
  text-align: center;
  margin-bottom: 20px;
}

.modal-header h2 {
  font-size: 26px;
  font-weight: 700;
}

.modal-header p {
  font-size: 13px;
  opacity: 0.7;
}

/* INPUTЫ как у твоей формы */
.input-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 14px;
}

.input-group label {
  margin-bottom: 6px;
  font-size: 13px;
  opacity: 0.85;
}

.input-group input,
.input-group textarea {
  padding: 14px 16px;

  border-radius: 16px;
  border: 1px solid rgba(255, 255, 255, 0.3);

  background: rgba(255, 255, 255, 0.12);
  color: white;

  outline: none;
  transition: 0.3s;
}

.input-group textarea {
  min-height: 90px;
  resize: none;
}

.input-group input:focus,
.input-group textarea:focus {
  border-color: #ff9f4d;
  box-shadow: 0 0 0 4px rgba(255, 159, 77, 0.25);
  background: rgba(255, 255, 255, 0.2);
}

/* КНОПКИ */
.modal-actions {
  display: flex;
  gap: 10px;
  margin-top: 15px;
}

.save-btn {
  flex: 1;
  padding: 14px;
  border-radius: 16px;

  background: rgba(255, 140, 40, 0.25);
  border: 1px solid rgba(255, 160, 60, 0.6);

  color: white;
  font-weight: 600;

  cursor: pointer;
  transition: 0.3s;
}

.save-btn:hover {
  background: rgba(255, 140, 40, 0.45);
  transform: translateY(-2px);
}

.cancel-btn {
  flex: 1;
  padding: 14px;
  border-radius: 16px;

  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.25);

  color: white;
  cursor: pointer;
  transition: 0.3s;
}

.cancel-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
}

.delete-btn {
  padding: 10px 14px;
  border-radius: 16px;

  background: rgba(255, 80, 80, 0.12);
  border: 1px solid rgba(255, 80, 80, 0.4);

  color: #ff6b6b;
  font-weight: 600;

  cursor: pointer;
  transition: 0.3s;
}

.delete-btn:hover {
  background: rgba(255, 80, 80, 0.25);
  transform: translateY(-2px);
}
</style>
<template>
  <AppMenu v-if="userRole !== 0" />
  <div class="wrapper">
    <img :src="bg" class="bg" />

    <div class="layout">

      <!-- СЛЕВА: ЧАТЫ -->
      <div class="sidebar">
        <h2 class="title">Чаты</h2>

        <div
          v-for="chat in chats"
          :key="chat.id"
          class="chat-item"
          :class="{ active: chat.id === activeChatId }"
          @click="openChat(chat)"
        >
          <p>{{ getChatName(chat) }}</p>
        </div>
      </div>

      <!-- СПРАВА: ЧАТ -->
      <div class="chat-box" v-if="activeChat">

        <!-- сообщения -->
        <div class="messages">
          <div
            v-for="msg in messages"
            :key="msg.id"
            class="message"
            :class="{ mine: msg.user_id === myId }"
          >
            <small class="author">
              {{ msg.user?.login || 'User #' + msg.user_id }}
            </small>

            <p v-if="msg.text">{{ msg.text }}</p>

            <a v-if="msg.filePath" :href="msg.filePath" target="_blank">
              📎 файл
            </a>

            <span class="time">
              {{ formatDate(msg.created_at) }}
            </span>
          </div>
        </div>

        <!-- ввод -->
        <div class="input-box">
          <input v-model="text" placeholder="Сообщение..." />

          <input type="file" @change="handleFile" />

          <button @click="sendMessage">Отправить</button>
        </div>

      </div>

      <div v-else class="empty">
        Выберите чат
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppMenu from './items/AppMenu.vue'

const API = 'http://localhost:8000'

const bg = ref('img/fon.png')

const chats = ref([])
const messages = ref([])

const activeChat = ref(null)
const activeChatId = ref(null)

const text = ref('')
const file = ref(null)

const myId = ref(null)

const userRole = ref(null)

/* ---------------- USER ---------------- */
const fetchUser = async () => {
  const res = await fetch(`${API}/api/user`, {
    credentials: 'include'
  })

  if (!res.ok) return

  const data = await res.json()

  myId.value = data.data.id
  userRole.value = data.data.role   // 👈 ВОТ ЭТО ДОБАВЬ

  console.log(data);
}

/* ---------------- CHAT NAME ---------------- */
const getChatName = (chat) => {
  if (!myId.value) return '...'

  if (chat.author_id === myId.value) {
    return chat.interlocutor?.login || 'Пользователь'
  } else {
    return chat.author?.login || 'Пользователь'
  }
}

/* ---------------- CHAT LIST ---------------- */
const fetchChats = async () => {
  const res = await fetch(`${API}/api/chats`, {
    credentials: 'include'
  })

  if (!res.ok) return

  const data = await res.json()
  chats.value = data
}

/* ---------------- OPEN CHAT ---------------- */
const openChat = async (chat) => {
  activeChat.value = chat
  activeChatId.value = chat.id
  await fetchMessages(chat.id)
}

/* ---------------- MESSAGES ---------------- */
const fetchMessages = async (chatId) => {
  const res = await fetch(`${API}/api/chats/${chatId}/messages`, {
    credentials: 'include'
  })

  if (!res.ok) {
    console.log('Ошибка загрузки сообщений')
    return
  }

  const data = await res.json()
  messages.value = data
}

/* ---------------- SEND MESSAGE ---------------- */
const handleFile = (e) => {
  file.value = e.target.files[0]
}

const sendMessage = async () => {
  if (!activeChat.value) return

  const formData = new FormData()
  formData.append('text', text.value || '')
  formData.append('chat_id', activeChat.value.id)

  if (file.value) {
    formData.append('file', file.value)
  }

  await fetch(`${API}/api/messages`, {
  method: 'POST',
  credentials: 'include',
  headers: {
    'Accept': 'application/json'
  },
  body: formData
})

  text.value = ''
  file.value = null

  await fetchMessages(activeChat.value.id)
}

/* ---------------- INIT ---------------- */
onMounted(async () => {
  await fetchUser()
  await fetchChats()
})

/* ---------------- FORMAT ---------------- */
const formatDate = (d) => {
  return new Date(d).toLocaleTimeString('ru-RU', {
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>

<style scoped>
.wrapper {
  position: fixed;
  inset: 0;
  color: white;
  font-family: system-ui;
}

.bg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: brightness(0.75);
  z-index: -1;
}

.layout {
  display: flex;
  height: 100%;
}

/* sidebar */
.sidebar {
  width: 280px;
  padding: 20px;
  background: rgba(255,255,255,0.08);
  backdrop-filter: blur(20px);
  border-right: 1px solid rgba(255,255,255,0.2);
}

.title {
  margin-bottom: 20px;
}

.chat-item {
  padding: 12px;
  margin-bottom: 10px;
  border-radius: 14px;
  cursor: pointer;
  background: rgba(255,255,255,0.08);
  transition: 0.2s;
}

.chat-item:hover {
  transform: translateY(-2px);
}

.chat-item.active {
  background: rgba(255, 159, 77, 0.2);
  border: 1px solid #ff9f4d;
}

/* chat */
.chat-box {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 20px;
}

/* messages */
.messages {
  flex: 1;
  overflow-y: auto;
  padding: 10px;
}

.message {
  max-width: 60%;
  padding: 12px;
  margin-bottom: 10px;
  border-radius: 14px;
  background: rgba(255,255,255,0.08);
  display: flex;
  flex-direction: column;
}

.message.mine {
  margin-left: auto;
  background: linear-gradient(135deg, #ff9f4d, #ff7a00);
}

.author {
  font-size: 11px;
  opacity: 0.7;
  margin-bottom: 4px;
}

.message.mine .author {
  text-align: right;
}

.time {
  font-size: 11px;
  opacity: 0.6;
  margin-top: 5px;
}

/* input */
.input-box {
  display: flex;
  gap: 10px;
  padding: 10px;
}

input {
  flex: 1;
  padding: 12px;
  border-radius: 12px;
  border: none;
  background: rgba(255,255,255,0.12);
  color: white;
}

button {
  padding: 12px 18px;
  border-radius: 12px;
  border: 1px solid rgba(255, 159, 77, 0.5);
  background: rgba(255, 159, 77, 0.2);
  color: white;
  cursor: pointer;
}

.empty {
  margin: auto;
  font-size: 18px;
  opacity: 0.7;
}
</style>
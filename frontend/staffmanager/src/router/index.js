import { createRouter, createWebHistory } from 'vue-router'

import MainPage from '@/components/MainPage.vue'
import AdminPage from '@/components/AdminPage.vue'
import VacanciesPage from '@/components/VacanciesPage.vue'
import LoginPage from '@/components/LoginPage.vue'
import RegisterPage from '@/components/RegisterPage.vue'
import ApplicationPage from '@/components/ApplicationPage.vue'
import ChatPage from '@/components/ChatPage.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: VacanciesPage,
  },{
    path: '/admin',
    name: 'admin',
    component: AdminPage
  },{
    path: '/form',
    name: 'form',
    component: MainPage
  },{
    path: '/login',
    name: 'login',
    component: LoginPage
  },{
    path: '/register',
    name: 'register',
    component: RegisterPage
  },{
    path: '/application',
    name: 'application',
    component: ApplicationPage
  },{
    path: '/chats',
    name: 'chats',
    component: ChatPage,
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
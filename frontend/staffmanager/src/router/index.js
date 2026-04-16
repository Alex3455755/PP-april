import { createRouter, createWebHistory } from 'vue-router'

import MainPage from '@/components/MainPage.vue'
import AdminPage from '@/components/AdminPage.vue'
import VacanciesPage from '@/components/VacanciesPage.vue'
import LoginPage from '@/components/LoginPage.vue'
import RegisterPage from '@/components/RegisterPage.vue'
import ApplicationPage from '@/components/ApplicationPage.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: MainPage,
  },{
    path: '/staff',
    name: 'staff',
    component: AdminPage
  },{
    path: '/vacancies',
    name: 'vacancies',
    component: VacanciesPage
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
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
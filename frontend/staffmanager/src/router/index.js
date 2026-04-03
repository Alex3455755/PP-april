import { createRouter, createWebHistory } from 'vue-router'

import MainPage from '@/components/MainPage.vue'
import AdminPage from '@/components/AdminPage.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: MainPage,
  },{
    path: '/staff',
    name: 'staff',
    component: AdminPage
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
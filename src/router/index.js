import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    component: () => import('@/features/dashboard/views/Dashboard.vue')
  },
  // Tambahkan route lain di sini
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

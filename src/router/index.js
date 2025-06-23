import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Main',
    component: () => import('@/layouts/Main.vue'),
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: () => import('@/features/dashboard/views/Dashboard.vue')
      },
      {
        path: 'business-field',
        name: 'BusinessField',
        // D:\learns\inventory-app\FE\src\features\business-field\views\BusinessFieldData.vue
        component: () => import('@/features/business-field/views/BusinessFieldData.vue')
      },
      {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('@/features/errors/views/NotFound.vue')
      }
    ],
  },
  // Tambahkan route lain di sini
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

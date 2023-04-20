import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Auth from '../Auth.vue'
import Layout from '../Layout.vue'
import LoginView from '../views/LoginView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path:'/auth',
      component: Auth,
      children: [
        {
          path: '/login',
          component:LoginView
        }
      ]
    },
    {
      path:'/',
      component:Layout,
      children: [
        {
          path: '/home',
          alias:'',
          name: 'home',
          component: HomeView
        }
      ]
    }
  ]
})

// Navigation guard to check if the user is authenticated
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('access_token')
  if (to.path !== '/login' && !isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})

export default router

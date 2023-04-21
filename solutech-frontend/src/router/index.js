import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import Auth from "../Auth.vue";
import Layout from "../Layout.vue";
import LoginView from "../views/LoginView.vue";
import TaskForm from "../components/TaskForm.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/auth",
      component: Auth,
      children: [
        {
          path: "/login",
          component: LoginView,
        },
      ],
    },
    {
      path: "/",
      component: Layout,
      children: [
        {
          path: "/home",
          alias: "",
          name: "home",
          component: HomeView,
        },
        {
          path: "/task",
          name: "add-task",
          component: TaskForm,
        },
        {
          path: "/task/:id",
          name: "edit-task",
          component: TaskForm,
        },
      ],
    },
  ],
});

// Navigation guard to check if the user is authenticated
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem("access_token");
  if (to.path !== "/login" && !isAuthenticated) {
    next("/login");
  } else {
    next();
  }
});

export default router;

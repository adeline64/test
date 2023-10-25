import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CartView from '../views/CartView.vue'
import LogoutView from '../views/LogoutView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import { useStore } from 'vuex';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView
    },
    {
      path: "/cart",
      name: "cart",
      component: CartView
    },
    {
      path: "/logout",
      name: "logout",
      component: LogoutView
    },
    {
      path: "/login",
      name: "login",
      component: LoginView
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView
    }
  ]
})

router.beforeEach((to, from, next) => {
  const store = useStore();
  
  if (to.name === 'logout') {
    // If the user is going to the 'logout' route, set the mode to 'login'
    store.dispatch('setMode', 'login');
  }

  next(); // Continue with the navigation
});

export default router

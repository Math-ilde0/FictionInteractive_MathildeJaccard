import { createRouter, createWebHistory } from 'vue-router';
import StoryList from '/resources/js/Pages/StoryList.vue';
import Chapter from './components/Chapter.vue';
import Result from './components/Result.vue';
import { getCookie } from './utils/cookies';
import Login from '@/Pages/Auth/Login.vue';
import Register from '@/Pages/Auth/Register.vue';
import Testimonies from '/resources/js/components/Testimonies/TestimoniesList.vue';
import TestimonyModeration from '@/Pages/Admin/TestimonyModeration.vue';
import { isAuthenticated } from './auth'; 

const routes = [
  {
    path: '/',
    redirect: '/stories'
  },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/testimonies', component: Testimonies, meta: {requiresAuth: true} },
  { path: '/admin/testimonies', component: TestimonyModeration, name: 'AdminTestimonies' },
  
  {
    path: '/stories',
    name: 'StoryList',
    component: StoryList,
    alias: '/'
  },
  {
    path: '/story/:storyId/chapter/:chapterId',
    component: Chapter,
  },
  {
    path: '/result/:outcome',
    component: Result,
    props: true,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard pour vérifier les conditions d'échec avant chaque changement de route
router.beforeEach((to, from, next) => {
  // Ignorer les routes /api et les routes de résultat
  if (to.path.startsWith('/api') || to.path.startsWith('/result')) {
    next();
    return;
  }
  
  // Vérifier le niveau de stress dans les cookies (si disponible)
  const stress = parseInt(getCookie('stress_level')) || 0;
  const sleep = parseInt(getCookie('sleep_level')) || 10;
  const grades = parseInt(getCookie('grades_level')) || 7;
  

  // Rediriger en fonction des métriques
  if (stress >= 10) {
    next('/result/failure');
  } else if (sleep <= 0) {
    next('/result/sleep-crisis');
  } else if (grades <= 0) {
    next('/result/academic-crisis');
  } else {
    next();
  }
  // Add navigation guard for authenticated routes
router.beforeEach((to, from, next) => {
  // Check for routes that require authentication
  if (to.meta.requiresAuth && !isAuthenticated.value) {
    next('/login');
  } else if ((to.path === '/login' || to.path === '/register') && isAuthenticated.value) {
    // Redirect to home if user is already logged in
    next('/');
  } else {
    next();
  }
});
});

export default router;
import { createRouter, createWebHistory } from 'vue-router';
import StoryList from '/resources/js/components/StoryList.vue';
import Chapter from './components/Chapter.vue';
import Result from './components/Result.vue';
import Login from '/resources/js/components/Auth/Login.vue';
import Register from '@/components/Auth/Register.vue';
import Testimonies from '/resources/js/components/Testimonies/TestimoniesList.vue';
import { user } from './auth';
import TestimonyCreate from './components/Testimonies/TestimonyCreate.vue'; 
import { getMetric } from '@/utils/metrics';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: StoryList
  },  
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/testimonies', component: Testimonies, meta: {requiresAuth: true} },
  { 
    path: '/testimonies/create', 
    component: TestimonyCreate,
    meta: { requiresAuth: true } 
  },
  {
    path: '/stories',
    name: 'StoryList',
    component: StoryList,
    alias: '/'
  },
  {
    path: '/story/:storyId',
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
// Then update the navigation guard
router.beforeEach((to, from, next) => {
  // Ignorer les routes /api et les routes de résultat
  if (to.path.startsWith('/api') || to.path.startsWith('/result')) {
    next();
    return;
  }

  // Get metrics from localStorage
  const stress = getMetric('stress_level', 3);
  const sleep = getMetric('sleep_level', 7);
  const grades = getMetric('grades_level', 6);

  // Rediriger en fonction des métriques
  if (stress >= 10) {
    next('/result/failure');
    return;
  } else if (sleep <= 0) {
    next('/result/sleep-crisis');
    return;
  } else if (grades <= 0) {
    next('/result/academic-crisis');
    return;
  }

  // Check for routes that require authentication
  if (to.meta.requiresAuth && !user.value) {
    next('/login');
    return;
  }


  next();
});

export default router;
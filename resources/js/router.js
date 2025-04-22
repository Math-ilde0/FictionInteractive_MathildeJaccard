import { createRouter, createWebHistory } from 'vue-router';
import StoryList from './components/StoryList.vue';
import Chapter from './components/Chapter.vue';
import Result from './components/Result.vue';
import { getCookie } from './utils/cookies';

const routes = [
  {
    path: '/',
    redirect: '/stories'
  },
  
  {
    path: '/stories',
    name: 'StoryList',
    component: StoryList,
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
});

export default router;
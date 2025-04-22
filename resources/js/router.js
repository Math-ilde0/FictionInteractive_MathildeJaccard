import { createRouter, createWebHistory } from 'vue-router';
import StoryList from './components/StoryList.vue';
import Chapter from './components/Chapter.vue';
import Result from './components/Result.vue';

const routes = [
  {
    path: '/',
    component: StoryList,
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
  
  // Vérifier le niveau de stress dans la session (si disponible)
  const stress = parseInt(localStorage.getItem('stress_level')) || 0;
  const sleep = parseInt(localStorage.getItem('sleep_level')) || 10;
  const grades = parseInt(localStorage.getItem('grades_level')) || 7;
  
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
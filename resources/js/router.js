/**
 * @file router.js
 * @description
 * Configuration des routes Vue Router pour l'application "Batterie Mentale".
 * Ce routeur gère :
 * - Les pages d'accueil, de connexion, d'inscription et de témoignages.
 * - L'affichage des chapitres d'histoire et des pages de fin (résultats).
 * - Les gardes de navigation : vérification des métriques (échec) et de l'authentification.
 *
 * @routes protégées : /testimonies, /testimonies/create (auth requise)
 * @routes de jeu : /story/:id, /result/:outcome
 * @fail logic : redirection automatique vers une page de fin si seuil critique atteint.
 *
 * @auteur Mathilde Jaccard – HEIG-VD, Bachelor Media Engineering
 * @date Mai 2025
 */

import { createRouter, createWebHistory } from 'vue-router';
import StoryList from '/resources/js/components/StoryList.vue';
import Chapter from './components/Chapter.vue';
import Result from './components/Result.vue';
import Login from '/resources/js/components/Auth/Login.vue';
import Register from '@/components/Auth/Register.vue';
import Testimonies from '/resources/js/components/Testimonies/TestimoniesList.vue';
import TestimonyCreate from './components/Testimonies/TestimonyCreate.vue'; 
import { user } from './auth';
import { getMetric } from '@/utils/metrics';

// Déclaration des routes de l'application
const routes = [
  { path: '/', name: 'Home', component: StoryList },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/testimonies', component: Testimonies, meta: { requiresAuth: true } },
  { path: '/testimonies/create', component: TestimonyCreate, meta: { requiresAuth: true } },
  { path: '/stories', name: 'StoryList', component: StoryList, alias: '/' },
  { path: '/story/:storyId', component: Chapter },
  { path: '/result/:outcome', component: Result, props: true }
];

// Création du routeur
const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Garde de navigation : vérifie les métriques et l'authentification avant chaque route
router.beforeEach((to, from, next) => {
  // Ignorer certaines routes
  if (to.path.startsWith('/api') || to.path.startsWith('/result')) {
    next();
    return;
  }

  // Vérification des métriques critiques
  const stress = getMetric('stress_level', 3);
  const sleep = getMetric('sleep_level', 7);
  const grades = getMetric('grades_level', 6);

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

  // Vérification d’authentification si nécessaire
  if (to.meta.requiresAuth && !user.value) {
    next('/login');
    return;
  }

  // Sinon, continuer normalement
  next();
});

export default router;

<!--
/**
 * @component Result.vue
 * Affiche l'écran final du jeu selon l'issue (succès, burn-out, échec scolaire, etc.).
 *
 * Affichage conditionnel basé sur : `/result/:outcome`
 * Donne des conseils selon le scénario atteint + liens utiles.
 * 
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <main class="min-h-screen py-10 px-4 bg-gray-50 dark:bg-gray-900 transition-colors">
    <!-- Conteneur principal du résultat -->
    <div v-if="outcome" class="max-w-4xl mx-auto p-8 rounded-lg shadow-md bg-white dark:bg-gray-800 transition-colors">
      <div :class="resultClasses">
        <!-- Titre et message principal -->
        <h2 class="text-3xl font-bold text-center mb-4 dark:text-white transition-colors">{{ title }}</h2>
        <p class="text-gray-500 dark:text-gray-400 italic text-center mb-6 transition-colors">{{ introText }}</p>
        <p class="text-gray-700 dark:text-gray-300 text-center mb-6 transition-colors">{{ message }}</p>

        <!-- Résultat : succès -->
        <div v-if="outcome === 'success'" class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg p-4 text-center font-semibold mb-6 transition-colors">
          🌟 Tu franchis la ligne d'arrivée, équilibré et fier.
        </div>

        <!-- Résultat : avertissement -->
        <div v-else-if="outcome === 'warning'" class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-lg p-4 text-center font-semibold mb-6 transition-colors">
          ⚠️ Tu termines sur les genoux, mais debout.
        </div>

        <!-- Résultat : burn-out -->
        <div v-else-if="outcome === 'failure'" class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg p-4 text-center font-semibold mb-6 transition-colors">
          🔥 Tu te réveilles sur le canapé d'un ami, vidé, incapable de retourner en cours.
        </div>

        <!-- Résultat : crise de sommeil -->
        <div v-else-if="outcome === 'sleep-crisis'" class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg p-4 text-center font-semibold mb-6 transition-colors">
          😴 Tu t'es endormi sur le clavier, les pages de code restées incomplètes.
        </div>

        <!-- Résultat : échec académique -->
        <div v-else-if="outcome === 'academic-crisis'" class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-lg p-4 text-center font-semibold mb-6 transition-colors">
          📉 Les résultats sont tombés, et ils piquent.
        </div>

        <!-- Résultat inconnu -->
        <div v-else class="text-center text-gray-500 dark:text-gray-400 transition-colors">
          ⚠️ Une erreur est survenue.
        </div>

        <!-- Conseils personnalisés -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md mt-6 transition-colors" v-if="adviceList.length">
          <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-200 transition-colors">{{ adviceTitle }}</h3>
          <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300 transition-colors">
            <li v-for="(item, index) in adviceList" :key="index">{{ item }}</li>
          </ul>
        </div>
      </div>

      <!-- Boutons d'action -->
      <div class="flex justify-center gap-4 mt-10">
        <router-link
          to="/"
          class="px-6 py-2 bg-green-500 dark:bg-green-600 text-white rounded hover:bg-green-600 dark:hover:bg-green-700 text-center transition-colors"
        >
          {{ buttonText }}
        </router-link>
      </div>
    </div>
  </main>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const outcome = computed(() => route.params.outcome);

// Définir les classes Tailwind pour chaque résultat
const resultClasses = computed(() => {
  return 'rounded-lg border-l-4 p-4 mb-6 transition-colors ' + {
    success: 'bg-green-50 dark:bg-green-900/30 border-green-400 dark:border-green-600',
    warning: 'bg-yellow-50 dark:bg-yellow-900/30 border-yellow-400 dark:border-yellow-600',
    failure: 'bg-red-50 dark:bg-red-900/30 border-red-400 dark:border-red-600',
    'sleep-crisis': 'bg-blue-50 dark:bg-blue-900/30 border-blue-400 dark:border-blue-600',
    'academic-crisis': 'bg-purple-50 dark:bg-purple-900/30 border-purple-400 dark:border-purple-600',
  }[outcome.value] || 'bg-gray-100 dark:bg-gray-800 border-gray-400 dark:border-gray-600';
});

// Titre principal
const title = computed(() => ({
  success: 'Félicitations !',
  warning: 'Mission accomplie... mais à quel prix ?',
  failure: 'Burn-out !',
  'sleep-crisis': 'Épuisement total !',
  'academic-crisis': 'Échec académique !',
}[outcome.value] || 'Fin de partie'));

// Texte d'introduction
const introText = computed(() => ({
  success: 'Tu as réussi à maintenir un équilibre sain.',
  warning: 'Tu as atteint tes objectifs, mais ta santé mentale en a souffert.',
  failure: 'Tu as poussé ton esprit au-delà de ses limites.',
  'sleep-crisis': 'Le manque de sommeil t\'a rattrapé.',
  'academic-crisis': 'Tes notes ont trop chuté.',
}[outcome.value] || 'Le jeu est terminé.'));

// Message principal
const message = computed(() => ({
  success: 'Tu as trouvé le juste équilibre entre tes études et ton bien-être.',
  warning: 'Attention à ne pas reproduire ces schémas à l\'avenir.',
  failure: 'Il est temps de prendre soin de toi et de demander de l\'aide.',
  'sleep-crisis': 'Le sommeil est essentiel pour ton corps et ton esprit.',
  'academic-crisis': 'Apprendre de ses erreurs est aussi important que réussir.',
}[outcome.value] || 'Merci d\'avoir joué !'));

// Texte du bouton
const buttonText = computed(() => 'Retourner à l\'accueil');

// Titre des conseils
const adviceTitle = computed(() => ({
  success: '🌱 Ce que tu as appris en chemin :',
  warning: '⚠️ Avant la prochaine fois, retiens cela :',
  failure: '🔥 Il est temps de t\'entourer :',
  'sleep-crisis': '😴 Pourquoi le sommeil n\'est jamais du temps perdu :',
  'academic-crisis': '📉 Comment rebondir plus fort :',
}[outcome.value] || 'Conseils utiles'));

// Liste des conseils affichés
const adviceList = computed(() => ({
  success: [
    'Planifier sans tout contrôler',
    'Dire non quand c\'est nécessaire',
    'Prioriser l\'essentiel sans culpabilité',
    'Demander de l\'aide au bon moment',
    'Respecter ton corps et ton esprit',
  ],
  warning: [
    'Repérer les signes d\'alerte du stress',
    'Faire des pauses plus tôt, pas quand il est trop tard',
    'Ne pas confondre performance et épuisement',
    'Mettre des limites même quand c\'est difficile',
  ],
  failure: [
    'Consulte 147.ch – Ligne gratuite 24h/24',
    'Ontecoute.ch – Soutien anonyme',
    'SantéPsy.ch – Soutien psychologique',
    'NoBurnout.ch – Ressources spécialisées',
  ],
  'sleep-crisis': [
    'Consolider les apprentissages de la journée',
    'Garder une mémoire vive',
    'Réguler tes émotions',
    'Préparer ton cerveau à résoudre des problèmes',
  ],
  'academic-crisis': [
    'Analyser ce qui n\'a pas fonctionné',
    'Demander des feedbacks aux professeurs',
    'Améliorer tes méthodes, pas juste le temps passé',
    'Revoir tes objectifs personnels',
    'Ne pas laisser les notes définir ta valeur',
  ],
}[outcome.value] || []));
</script>
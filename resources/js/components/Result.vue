<!--
/**
 * @component Result.vue
 * Affiche l’écran final du jeu selon l’issue (succès, burn-out, échec scolaire, etc.).
 *
 * Affichage conditionnel basé sur : `/result/:outcome`
 * Donne des conseils selon le scénario atteint + liens utiles.
 * 
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <main class="min-h-screen py-10 px-4 bg-gray-50">
    <!-- Conteneur principal du résultat -->
    <div v-if="outcome" class="max-w-4xl mx-auto p-8 rounded-lg shadow-md bg-white">
      <div :class="resultClasses">
        <!-- Titre et message principal -->
        <h2 class="text-3xl font-bold text-center mb-4">{{ title }}</h2>
        <p class="text-gray-500 italic text-center mb-6">{{ introText }}</p>
        <p class="text-gray-700 text-center mb-6">{{ message }}</p>

        <!-- Résultat : succès -->
        <div v-if="outcome === 'success'" class="bg-green-100 text-green-800 rounded-lg p-4 text-center font-semibold mb-6">
          🌟 Tu franchis la ligne d'arrivée, équilibré et fier.
        </div>

        <!-- Résultat : avertissement -->
        <div v-else-if="outcome === 'warning'" class="bg-yellow-100 text-yellow-800 rounded-lg p-4 text-center font-semibold mb-6">
          ⚠️ Tu termines sur les genoux, mais debout.
        </div>

        <!-- Résultat : burn-out -->
        <div v-else-if="outcome === 'failure'" class="bg-red-100 text-red-800 rounded-lg p-4 text-center font-semibold mb-6">
          🔥 Tu te réveilles sur le canapé d’un ami, vidé, incapable de retourner en cours.
        </div>

        <!-- Résultat : crise de sommeil -->
        <div v-else-if="outcome === 'sleep-crisis'" class="bg-blue-100 text-blue-800 rounded-lg p-4 text-center font-semibold mb-6">
          😴 Tu t’es endormi sur le clavier, les pages de code restées incomplètes.
        </div>

        <!-- Résultat : échec académique -->
        <div v-else-if="outcome === 'academic-crisis'" class="bg-purple-100 text-purple-800 rounded-lg p-4 text-center font-semibold mb-6">
          📉 Les résultats sont tombés, et ils piquent.
        </div>

        <!-- Résultat inconnu -->
        <div v-else class="text-center text-gray-500">
          ⚠️ Une erreur est survenue.
        </div>

        <!-- Conseils personnalisés -->
        <div class="bg-white p-6 rounded-lg shadow-md mt-6" v-if="adviceList.length">
          <h3 class="text-lg font-semibold mb-4 text-gray-700">{{ adviceTitle }}</h3>
          <ul class="list-disc list-inside space-y-2 text-gray-600">
            <li v-for="(item, index) in adviceList" :key="index">{{ item }}</li>
          </ul>
        </div>
      </div>

      <!-- Boutons d'action -->
      <div class="flex justify-center gap-4 mt-10">
        <router-link
          to="/"
          class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-center"
        >
          {{ buttonText }}
        </router-link>
        <button
          @click="restartGame"
          class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500"
        >
          Rejouer
        </button>
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
  return 'rounded-lg border-l-4 p-4 mb-6 ' + {
    success: 'bg-green-50 border-green-400',
    warning: 'bg-yellow-50 border-yellow-400',
    failure: 'bg-red-50 border-red-400',
    'sleep-crisis': 'bg-blue-50 border-blue-400',
    'academic-crisis': 'bg-purple-50 border-purple-400',
  }[outcome.value] || 'bg-gray-100 border-gray-400';
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
  failure: '🔥 Il est temps de t’entourer :',
  'sleep-crisis': '😴 Pourquoi le sommeil n’est jamais du temps perdu :',
  'academic-crisis': '📉 Comment rebondir plus fort :',
}[outcome.value] || 'Conseils utiles'));

// Liste des conseils affichés
const adviceList = computed(() => ({
  success: [
    'Planifier sans tout contrôler',
    'Dire non quand c’est nécessaire',
    'Prioriser l’essentiel sans culpabilité',
    'Demander de l’aide au bon moment',
    'Respecter ton corps et ton esprit',
  ],
  warning: [
    'Repérer les signes d’alerte du stress',
    'Faire des pauses plus tôt, pas quand il est trop tard',
    'Ne pas confondre performance et épuisement',
    'Mettre des limites même quand c’est difficile',
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
    'Analyser ce qui n’a pas fonctionné',
    'Demander des feedbacks aux professeurs',
    'Améliorer tes méthodes, pas juste le temps passé',
    'Revoir tes objectifs personnels',
    'Ne pas laisser les notes définir ta valeur',
  ],
}[outcome.value] || []));

// Redémarrer le jeu
const restartGame = async () => {
  try {
    await axios.post('/api/metrics/reset');
    localStorage.removeItem('storyProgress');
    router.push('/');
  } catch (error) {
    console.error('Erreur lors du redémarrage:', error);
    router.push('/');
  }
};
</script>

<!--
/**
 * @component AdviceTooltip.vue
 * Affiche des conseils personnalisés au survol des icônes :
 * - stress, sommeil, notes.
 *
 * Affichage conditionnel et animé avec Tailwind.
 * Utilisé après chaque chapitre pour informer l’utilisateur.
 *
 * @props : stressAdvice, sleepAdvice, gradesAdvice
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <!-- Conteneur principal avec fond doux et style de carte -->
  <div class="bg-gradient-to-br from-white via-gray-50 to-indigo-50 rounded-xl p-6 mt-8 text-center shadow-md border border-gray-200">
    <h3 class="text-xl mb-6 text-gray-700 font-semibold">🧘 Conseils personnalisés</h3>

    <!-- Icônes interactives affichant un tooltip au survol -->
    <div class="flex justify-center gap-10">
      <!-- Stress / Charge mentale -->
      <div 
        class="relative text-4xl cursor-pointer transition-transform hover:scale-110"
        @mouseover="showTooltip('stress')" 
        @mouseleave="hideTooltip"
      >
        <span>🧠</span>
        <div 
          v-if="currentTooltip === 'stress'"
          class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-56 bg-red-400 text-white text-sm rounded-lg p-3 shadow-lg animate-fade-in"
        >
          {{ stressAdvice }}
        </div>
      </div>

      <!-- Sommeil -->
      <div 
        class="relative text-4xl cursor-pointer transition-transform hover:scale-110"
        @mouseover="showTooltip('sleep')" 
        @mouseleave="hideTooltip"
      >
        <span>🛌</span>
        <div 
          v-if="currentTooltip === 'sleep'"
          class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-56 bg-blue-400 text-white text-sm rounded-lg p-3 shadow-lg animate-fade-in"
        >
          {{ sleepAdvice }}
        </div>
      </div>

      <!-- Notes / Réussite académique -->
      <div 
        class="relative text-4xl cursor-pointer transition-transform hover:scale-110"
        @mouseover="showTooltip('grades')" 
        @mouseleave="hideTooltip"
      >
        <span>🎓</span>
        <div 
          v-if="currentTooltip === 'grades'"
          class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-56 bg-green-400 text-white text-sm rounded-lg p-3 shadow-lg animate-fade-in"
        >
          {{ gradesAdvice }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Import de la fonction de réactivité
import { ref } from 'vue';

// Props reçues depuis le parent (conseils personnalisés)
const props = defineProps({
  stressAdvice: String,
  sleepAdvice: String,
  gradesAdvice: String
});

// Référence pour identifier le tooltip actif
const currentTooltip = ref(null);

// Afficher le tooltip selon l’icône survolée
const showTooltip = (type) => currentTooltip.value = type;

// Masquer le tooltip lorsqu’on quitte l’icône
const hideTooltip = () => currentTooltip.value = null;
</script>

<style scoped>
/* Animation douce d’apparition du tooltip */
@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fade-in 0.3s ease-out forwards;
}
</style>

<!--
/**
 * @component MetricsDisplay.vue
 * Affiche sous forme de barres les trois métriques du joueur :
 * - Charge mentale, Sommeil, Notes.
 *
 * Utilisé dans l’interface de jeu pour le suivi visuel.
 *
 * @props : level (stress), sleepLevel, gradesLevel
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <!-- Conteneur principal des barres de métriques -->
  <div class="flex flex-col gap-4 mb-5 bg-gray-50 p-4 rounded-lg">

    <!-- Charge Mentale -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap">🧠 Charge Mentale</div>
        <div class="flex-grow h-3 bg-gray-200 rounded-md overflow-hidden">
          <div
            class="h-full bg-red-500 transition-all duration-500"
            :style="{ width: `${stressPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>

    <!-- Sommeil -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap">😴 Sommeil</div>
        <div class="flex-grow h-3 bg-gray-200 rounded-md overflow-hidden">
          <div
            class="h-full bg-blue-500 transition-all duration-500"
            :style="{ width: `${sleepPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>

    <!-- Notes -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap">🎓 Notes</div>
        <div class="flex-grow h-3 bg-gray-200 rounded-md overflow-hidden">
          <div
            class="h-full bg-green-500 transition-all duration-500"
            :style="{ width: `${gradesPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
// Importation de Vue
import { computed } from 'vue'

// Déclaration des propriétés reçues
const props = defineProps({
  level: Number,         // Niveau de stress
  sleepLevel: Number,    // Niveau de sommeil
  gradesLevel: Number    // Niveau des notes
})

// Calculs des pourcentages pour les barres de progression
const stressPercentage = computed(() => Math.min((props.level ?? 3) * 10, 100))
const sleepPercentage = computed(() => Math.min((props.sleepLevel ?? 7) * 10, 100))
const gradesPercentage = computed(() => Math.min((props.gradesLevel ?? 6) * 10, 100))
</script>

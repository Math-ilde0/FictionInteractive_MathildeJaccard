<!--
/**
 * @component MetricsBars.vue
 * Composant visuel affichant les niveaux de charge mentale, de sommeil et de notes sous forme de barres de progression colorées.
 *
 * Utilisé dans l’interface principale du jeu pour représenter l’état actuel de l’utilisateur via trois indicateurs :
 *  - 🧠 Charge Mentale (rouge)
 *  - 😴 Sommeil (bleu)
 *  - 🎓 Notes (vert)
 *
 * Les niveaux sont fournis via des props (`level`, `sleepLevel`, `gradesLevel`) sous forme d'entiers (ex: de 0 à 10).
 * Le composant convertit chaque niveau en pourcentage (max 100%) et les applique dynamiquement à la largeur des barres.
 *
 * @props {Number} level - Niveau de charge mentale (0 à 10)
 * @props {Number} sleepLevel - Niveau de sommeil (0 à 10)
 * @props {Number} gradesLevel - Niveau des notes (0 à 10)
 *
 * @example
 * <MetricsBars :level="5" :sleepLevel="7" :gradesLevel="6" />
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Juin 2025
 */
-->

<template>
  <!-- Conteneur général -->
  <div class="flex flex-col gap-4 mb-5 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg transition-colors">

    <!-- Barre : Charge Mentale -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap dark:text-white transition-colors">
          🧠 Charge Mentale
        </div>
        <div class="flex-grow h-3 bg-gray-200 dark:bg-gray-600 rounded-md overflow-hidden transition-colors">
          <div
            class="h-full bg-red-500 transition-all duration-700 ease-in-out"
            :style="{ width: `${stressPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>

    <!-- Barre : Sommeil -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap dark:text-white transition-colors">
          😴 Sommeil
        </div>
        <div class="flex-grow h-3 bg-gray-200 dark:bg-gray-600 rounded-md overflow-hidden transition-colors">
          <div
            class="h-full bg-blue-500 transition-all duration-700 ease-in-out"
            :style="{ width: `${sleepPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>

    <!-- Barre : Notes -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap dark:text-white transition-colors">
          🎓 Notes
        </div>
        <div class="flex-grow h-3 bg-gray-200 dark:bg-gray-600 rounded-md overflow-hidden transition-colors">
          <div
            class="h-full bg-green-500 transition-all duration-700 ease-in-out"
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

/**
 * Props du composant :
 * - level : niveau de charge mentale (0 à 10)
 * - sleepLevel : niveau de sommeil (0 à 10)
 * - gradesLevel : niveau des notes (0 à 10)
 */
const props = defineProps({
  level: Number,
  sleepLevel: Number,
  gradesLevel: Number
})

/**
 * Calcul du pourcentage de charge mentale à afficher
 * @returns {number} entre 0% et 100%
 */
const stressPercentage = computed(() => Math.min((props.level ?? 3) * 10, 100))

/**
 * Calcul du pourcentage de sommeil à afficher
 * @returns {number} entre 0% et 100%
 */
const sleepPercentage = computed(() => Math.min((props.sleepLevel ?? 7) * 10, 100))

/**
 * Calcul du pourcentage des notes à afficher
 * @returns {number} entre 0% et 100%
 */
const gradesPercentage = computed(() => Math.min((props.gradesLevel ?? 6) * 10, 100))
</script>

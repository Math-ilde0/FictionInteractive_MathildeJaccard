<template>
  <!-- Conteneur principal des barres de métriques -->
  <div class="flex flex-col gap-4 mb-5 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg transition-colors">

    <!-- Charge Mentale -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap dark:text-white transition-colors">🧠 Charge Mentale</div>
        <div class="flex-grow h-3 bg-gray-200 dark:bg-gray-600 rounded-md overflow-hidden transition-colors">
          <div
            class="h-full bg-red-500 transition-all duration-700 ease-in-out"
            :style="{ width: `${stressPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>

    <!-- Sommeil -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap dark:text-white transition-colors">😴 Sommeil</div>
        <div class="flex-grow h-3 bg-gray-200 dark:bg-gray-600 rounded-md overflow-hidden transition-colors">
          <div
            class="h-full bg-blue-500 transition-all duration-700 ease-in-out"
            :style="{ width: `${sleepPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>

    <!-- Notes -->
    <div class="flex flex-col w-full">
      <div class="flex sm:flex-row flex-col sm:items-center items-start gap-4">
        <div class="font-bold text-base sm:w-1/3 w-full whitespace-nowrap dark:text-white transition-colors">🎓 Notes</div>
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
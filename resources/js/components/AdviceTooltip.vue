<template>
  <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl p-6 mt-8 text-center shadow-md border border-blue-300">
    <h3 class="text-xl mb-6 text-gray-700">🧘 Conseils personnalisés</h3>

    <div class="flex justify-center gap-10">
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
import { ref } from 'vue';

const props = defineProps({
  stressAdvice: String,
  sleepAdvice: String,
  gradesAdvice: String
});

const currentTooltip = ref(null);
const showTooltip = (type) => currentTooltip.value = type;
const hideTooltip = () => currentTooltip.value = null;
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fade-in 0.3s ease-out forwards;
}
</style>

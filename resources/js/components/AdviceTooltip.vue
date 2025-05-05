<template>
  <div class="advice-container">
    <h3 class="advice-title">🧘 Conseils personnalisés</h3>

    <div class="advice-icons">
      <div 
        class="advice-icon" 
        @mouseover="showTooltip('stress')" 
        @mouseleave="hideTooltip"
      >
        <i class="fas fa-brain"></i>
        <span class="tooltip-text stress" v-if="currentTooltip === 'stress'">{{ stressAdvice }}</span>
      </div>

      <div 
        class="advice-icon" 
        @mouseover="showTooltip('sleep')" 
        @mouseleave="hideTooltip"
      >
        <i class="fas fa-bed"></i>
        <span class="tooltip-text sleep" v-if="currentTooltip === 'sleep'">{{ sleepAdvice }}</span>
      </div>

      <div 
        class="advice-icon" 
        @mouseover="showTooltip('grades')" 
        @mouseleave="hideTooltip"
      >
        <i class="fas fa-graduation-cap"></i>
        <span class="tooltip-text grades" v-if="currentTooltip === 'grades'">{{ gradesAdvice }}</span>
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
.advice-container {
  background: linear-gradient(135deg, #f0f4f8, #e2f1f8); /* Bleu-gris pastel */
  border-radius: 12px;
  padding: 20px;
  margin-top: 30px;
  text-align: center;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  border: 1px solid #d0e6f2;
}

.advice-title {
  font-size: 1.4rem;
  margin-bottom: 20px;
  color: #444;
}

.advice-icons {
  display: flex;
  justify-content: center;
  gap: 40px;
}

.advice-icon {
  position: relative;
  font-size: 2.2rem;
  cursor: pointer;
  transition: transform 0.3s;
}

.advice-icon:hover {
  transform: scale(1.2);
}

.tooltip-text {
  position: absolute;
  bottom: 125%;
  left: 50%;
  transform: translateX(-50%);
  background-color: #333;
  color: white;
  padding: 10px 15px;
  border-radius: 8px;
  width: 240px;
  font-size: 0.9rem;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  z-index: 10;
  opacity: 0;
  animation: fadeIn 0.4s forwards;
  font-style: italic;
  pointer-events: none;
}

.tooltip-text.stress {
  background-color: #ef5350;
}

.tooltip-text.grades {
  background-color: #66bb6a;
}

.tooltip-text.sleep {
  background-color: #42a5f5;
}

@keyframes fadeIn {
  to {
    opacity: 1;
  }
}

@media (max-width: 600px) {
  .advice-icons {
    flex-direction: column;
    gap: 20px;
  }

  .tooltip-text {
    position: static;
    transform: none;
    width: 100%;
    margin-top: 10px;
    opacity: 1 !important;
    animation: none;
  }
}
</style>
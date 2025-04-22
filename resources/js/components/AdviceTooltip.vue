<template>
    <div class="advice-container">
      <h3 class="advice-title">🧘 Conseils pour ton bien-être</h3>
      
      <div class="advice-icons">
        <div 
          class="advice-icon" 
          @mouseover="showTooltip('stress')" 
          @mouseleave="hideTooltip"
        >
          <i class="fas fa-brain stress-icon"></i>
          <div v-if="currentTooltip === 'stress'" class="tooltip stress-tooltip">
            {{ stressAdvice }}
          </div>
        </div>
  
        <div 
          class="advice-icon" 
          @mouseover="showTooltip('sleep')" 
          @mouseleave="hideTooltip"
        >
          <i class="fas fa-bed sleep-icon"></i>
          <div v-if="currentTooltip === 'sleep'" class="tooltip sleep-tooltip">
            {{ sleepAdvice }}
          </div>
        </div>
  
        <div 
          class="advice-icon" 
          @mouseover="showTooltip('grades')" 
          @mouseleave="hideTooltip"
        >
          <i class="fas fa-graduation-cap grades-icon"></i>
          <div v-if="currentTooltip === 'grades'" class="tooltip grades-tooltip">
            {{ gradesAdvice }}
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    stressAdvice: {
      type: String,
      default: 'Prenez du recul et respirez profondément. Le stress se gère, pas se subit.'
    },
    sleepAdvice: {
      type: String,
      default: 'Un sommeil de qualité est essentiel. Établissez une routine de sommeil et respectez-la.'
    },
    gradesAdvice: {
      type: String,
      default: 'Concentrez-vous sur la compréhension, pas uniquement sur la note. Chaque apprentissage compte.'
    }
  });
  
  const currentTooltip = ref(null);
  
  const showTooltip = (type) => {
    currentTooltip.value = type;
  };
  
  const hideTooltip = () => {
    currentTooltip.value = null;
  };
  </script>
  
  <script>
  export default {
    name: 'AdviceTooltip'
  }
  </script>
  
  <style scoped>
  .advice-container {
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 20px;
    margin-top: 20px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .advice-title {
    margin-bottom: 15px;
    font-size: 1.2rem;
    color: #333;
  }
  
  .advice-icons {
    display: flex;
    justify-content: space-around;
    align-items: center;
  }
  
  .advice-icon {
    position: relative;
    cursor: help;
    transition: transform 0.3s ease;
  }
  
  .advice-icon:hover {
    transform: scale(1.1);
  }
  
  .advice-icon i {
    font-size: 2rem;
    transition: color 0.3s ease;
  }
  
  .stress-icon {
    color: #ef5350;
  }
  
  .sleep-icon {
    color: #4caf50;
  }
  
  .grades-icon {
    color: #2196f3;
  }
  
  .tooltip {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: white;
    padding: 10px;
    border-radius: 5px;
    width: 250px;
    text-align: center;
    z-index: 10;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
  }
  
  .advice-icon:hover .tooltip {
    opacity: 1;
    visibility: visible;
  }
  
  @media (max-width: 600px) {
    .advice-icons {
      flex-direction: column;
      gap: 20px;
    }
  
    .tooltip {
      position: static;
      transform: none;
      margin-top: 10px;
      opacity: 1;
      visibility: visible;
    }
  }
  </style>
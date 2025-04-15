<template>
    <div class="stress-container">
      <div class="stress-meter">
        <div class="stress-text">Niveau de stress: {{ level }}/10</div>
        <div class="stress-bar">
          <div
            class="stress-fill"
            :style="{ width: `${level * 10}%`, backgroundColor: stressColor }"
          ></div>
        </div>
        <div class="stress-emoji">{{ stressEmoji }}</div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  
  const props = defineProps({
    level: {
      type: Number,
      default: 0
    }
  });
  
  // Computed property for stress color
  const stressColor = computed(() => {
    const level = props.level;
    if (level <= 3) return '#a5d6a7'; // Vert pour stress faible
    if (level <= 7) return '#ffd54f'; // Jaune pour stress moyen
    return '#ef5350'; // Rouge pour stress élevé
  });
  
  // Computed property for stress emoji
  const stressEmoji = computed(() => {
    const level = props.level;
    if (level <= 3) return '😌'; // Détendu
    if (level <= 5) return '😐'; // Neutre
    if (level <= 7) return '😓'; // Inquiet
    if (level <= 9) return '😰'; // Très stressé
    return '🤯'; // Burnout imminent
  });
  </script>
  
  <style scoped>
  .stress-container {
    margin-bottom: 20px;
    border-radius: 8px;
    padding: 10px;
    background-color: #f9f9f9;
  }
  
  .stress-meter {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .stress-text {
    font-size: 1rem;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  .stress-bar {
    width: 100%;
    height: 10px;
    background-color: #e0e0e0;
    border-radius: 5px;
    overflow: hidden;
  }
  
  .stress-fill {
    height: 100%;
    transition: width 0.5s ease, background-color 0.5s ease;
  }
  
  .stress-emoji {
    font-size: 1.5rem;
    margin-top: 5px;
  }
  </style>
<template>
  <div class="metrics-container">
    <div class="metric-block">
      <div class="metric-label">Stress</div>
      <div class="stress-meter">
        <div class="stress-bar">
          <div 
            class="stress-fill" 
            :style="{ 
              width: `${stressPercentage}%`, 
              backgroundColor: stressColor 
            }"
          ></div>
        </div>
        <div class="metric-emoji">{{ stressEmoji }}</div>
      </div>
    </div>

    <div class="metric-block">
      <div class="metric-label">Sommeil</div>
      <div class="sleep-meter">
        <div class="sleep-bar">
          <div 
            class="sleep-fill" 
            :style="{ 
              width: `${sleepPercentage}%`, 
              backgroundColor: sleepColor 
            }"
          ></div>
        </div>
        <div class="metric-emoji">{{ sleepEmoji }}</div>
      </div>
    </div>

    <div class="metric-block">
      <div class="metric-label">Notes</div>
      <div class="grades-meter">
        <div class="grades-bar">
          <div 
            class="grades-fill" 
            :style="{ 
              width: `${gradesPercentage}%`, 
              backgroundColor: gradesColor 
            }"
          ></div>
        </div>
        <div class="metric-emoji">{{ gradesEmoji }}</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  level: {
    type: Number,
    default: 0
  },
  sleepLevel: {
    type: Number, 
    default: 10
  },
  gradesLevel: {
    type: Number, 
    default: 7
  }
});

// Stress Color and Emoji Computation
const stressColor = computed(() => {
  const level = props.level;
  if (level <= 3) return '#a5d6a7'; // Vert pour stress faible
  if (level <= 7) return '#ffd54f'; // Jaune pour stress moyen
  return '#ef5350'; // Rouge pour stress élevé
});

const stressEmoji = computed(() => {
  const level = props.level;
  if (level <= 3) return '😌'; // Détendu
  if (level <= 5) return '😐'; // Neutre
  if (level <= 7) return '😓'; // Inquiet
  if (level <= 9) return '😰'; // Très stressé
  return '🤯'; // Burnout imminent
});

// Sleep Color and Emoji Computation
const sleepColor = computed(() => {
  const level = props.sleepLevel;
  if (level >= 8) return '#a5d6a7'; // Vert pour bien reposé
  if (level >= 5) return '#ffd54f'; // Jaune pour moyen
  return '#ef5350'; // Rouge pour mal reposé
});

const sleepEmoji = computed(() => {
  const level = props.sleepLevel;
  if (level >= 8) return '😴'; // Bien reposé
  if (level >= 5) return '😑'; // Fatigué
  return '🥱'; // Très fatigué
});

// Grades Color and Emoji Computation
const gradesColor = computed(() => {
  const level = props.gradesLevel;
  if (level >= 8) return '#a5d6a7'; // Vert pour très bon
  if (level >= 5) return '#ffd54f'; // Jaune pour moyen
  return '#ef5350'; // Rouge pour faible
});

const gradesEmoji = computed(() => {
  const level = props.gradesLevel;
  if (level >= 8) return '🏆'; // Excellent
  if (level >= 5) return '📚'; // Correct
  return '😱'; // En danger
});

// Percentage Computations
const stressPercentage = computed(() => Math.min(props.level * 10, 100));
const sleepPercentage = computed(() => Math.min(props.sleepLevel * 10, 100));
const gradesPercentage = computed(() => Math.min(props.gradesLevel * 10, 100));
</script>

<style scoped>
.metrics-container {
  display: flex;
  justify-content: space-between;
  gap: 15px;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
}

.metric-block {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.metric-label {
  font-weight: bold;
  margin-bottom: 5px;
  text-align: center;
  font-size: 0.9rem;
}

.stress-meter, .sleep-meter, .grades-meter {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.stress-bar, .sleep-bar, .grades-bar {
  width: 100%;
  height: 10px;
  background-color: #e0e0e0;
  border-radius: 5px;
  overflow: hidden;
  margin-bottom: 5px;
}

.stress-fill, .sleep-fill, .grades-fill {
  height: 100%;
  transition: width 0.5s ease, background-color 0.5s ease;
}

.metric-emoji {
  font-size: 1.2rem;
}

@media (max-width: 600px) {
  .metrics-container {
    flex-direction: column;
  }
}
</style>
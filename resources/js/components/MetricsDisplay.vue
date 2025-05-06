<template>
  <div class="metrics-container">
    <div class="metric-block">
      <div class="metric-line">
        <div class="metric-label">🧠 Charge Mentale</div>
        <div class="stress-bar">
          <div 
            class="stress-fill" 
            :style="{ 
              width: `${stressPercentage}%`, 
              backgroundColor: stressColor 
            }"
          ></div>
        </div>
      </div>
    </div>

    <div class="metric-block">
      <div class="metric-line">
        <div class="metric-label">😴 Sommeil</div>
        <div class="sleep-bar">
          <div 
            class="sleep-fill" 
            :style="{ 
              width: `${sleepPercentage}%`, 
              backgroundColor: sleepColor 
            }"
          ></div>
        </div>
      </div>
    </div>

    <div class="metric-block">
      <div class="metric-line">
        <div class="metric-label">🎓 Notes</div>
        <div class="grades-bar">
          <div 
            class="grades-fill" 
            :style="{ 
              width: `${gradesPercentage}%`, 
              backgroundColor: gradesColor 
            }"
          ></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  level: Number,
  sleepLevel: Number,
  gradesLevel: Number
});

const stressColor = computed(() => {
  const level = props.level ?? 3;  // 👈 valeur par défaut si undefined
  if (level <= 3) return '#a5d6a7';
  if (level <= 7) return '#ffd54f';
  return '#ef5350';
});

const sleepColor = computed(() => {
  const level = props.sleepLevel ?? 7;
  if (level >= 8) return '#a5d6a7';
  if (level >= 5) return '#ffd54f';
  return '#ef5350';
});

const gradesColor = computed(() => {
  const level = props.gradesLevel ?? 6;
  if (level >= 8) return '#a5d6a7';
  if (level >= 5) return '#ffd54f';
  return '#ef5350';
});

const stressPercentage = computed(() => Math.min((props.level ?? 3) * 10, 100));
const sleepPercentage = computed(() => Math.min((props.sleepLevel ?? 7) * 10, 100));
const gradesPercentage = computed(() => Math.min((props.gradesLevel ?? 6) * 10, 100));

</script>

<style scoped>
.metrics-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
}

.metric-block {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.metric-line {
  display: flex;
  align-items: center;
  gap: 15px;
}

.metric-label {
  font-weight: bold;
  font-size: 1rem;
  width: 30%;
  white-space: nowrap;
}

.stress-bar, .sleep-bar, .grades-bar {
  flex-grow: 1;
  height: 12px;
  background-color: #e0e0e0;
  border-radius: 6px;
  overflow: hidden;
}

.stress-fill, .sleep-fill, .grades-fill {
  height: 100%;
  transition: width 0.5s ease, background-color 0.5s ease;
}

@media (max-width: 600px) {
  .metrics-container {
    flex-direction: column;
  }
  .metric-line {
    flex-direction: column;
    align-items: flex-start;
  }
  .metric-label {
    width: 100%;
  }
}
</style>
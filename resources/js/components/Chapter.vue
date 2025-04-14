<template>
  <main>
    <div class="book-page" :style="pageEffects">
      <div class="stress-container">
        <div class="stress-meter">
          <div class="stress-text">Niveau de stress: {{ chapter?.stress_level || 5 }}/10</div>
          <div class="stress-bar">
            <div
              class="stress-fill"
              :style="{ width: `${(chapter?.stress_level || 5) * 10}%`, backgroundColor: stressColor }"
            ></div>
          </div>
          <div class="stress-emoji">{{ stressEmoji }}</div>
        </div>
      </div>
      
      <h1>Chapitre {{ chapter?.chapter_number || '?' }}</h1>
      
      <p>{{ chapter?.content }}</p>
    
      
      <ul class="choice-list">
  <li v-for="choice in choices" :key="choice.id" class="choice-item">
    <button @click="goToChapter(choice)">
      {{ choice.text }}
    </button>
    <div class="stress-tip">
      <i class="fas fa-info-circle"></i>
      <span class="tip-text">{{ choice.stress_advice }}</span>
    </div>
  </li>
</ul>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const chapter = ref({});
const choices = ref([]);
const stressLevel = ref(5);
const route = useRoute();
const router = useRouter();

// Computed property for stress color
const stressColor = computed(() => {
  const level = chapter.value?.stress_level || 5;
  if (level <= 3) return '#a5d6a7'; // Vert pour stress faible
  if (level <= 7) return '#ffd54f'; // Jaune pour stress moyen
  return '#ef5350'; // Rouge pour stress élevé
});

// Computed property for stress emoji
const stressEmoji = computed(() => {
  const level = chapter.value?.stress_level || 5;
  if (level <= 3) return '😌'; // Détendu
  if (level <= 5) return '😐'; // Neutre
  if (level <= 7) return '😓'; // Inquiet
  if (level <= 9) return '😰'; // Très stressé
  return '🤯'; // Burnout imminent
});

// Computed property pour les effets visuels de stress
const pageEffects = computed(() => {
  const level = chapter.value?.stress_level || 5;
  if (level <= 3) return {};
  if (level <= 6) return { 
    boxShadow: '0 8px 20px rgba(255, 213, 79, 0.2)'
  };
  if (level <= 8) return { 
    boxShadow: '0 8px 20px rgba(239, 83, 80, 0.3)',
    animation: 'heartbeat 3s infinite'
  };
  return { 
    boxShadow: '0 8px 20px rgba(239, 83, 80, 0.5)',
    animation: 'shake 0.5s infinite'
  };
});

// Function to fetch chapter data
const fetchChapter = async () => {
  const { storyId, chapterId } = route.params;
  
  try {
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    chapter.value = response.data;
    choices.value = response.data.choices;
    stressLevel.value = response.data.stress_level || 5;
    
    // Sauvegarder le niveau de stress dans localStorage pour le garder entre les chapitres
    localStorage.setItem('stressLevel', stressLevel.value);
  } catch (error) {
    console.error('Erreur de chargement du chapitre:', error);
  }
};

// Function to navigate to the next chapter
const goToChapter = (choice) => {
  if (!choice) {
    console.error('Choix invalide');
    return;
  }

  const chapterId = choice.next_chapter_id;

  if (chapterId === null) {
    // Déterminer l'issue en fonction du niveau de stress accumulé
    const stressScore = localStorage.getItem('stressLevel') || 5;
    const outcome = stressScore >= 8 ? 'failure' : 'success';
    window.location.href = `/result/${outcome}`;
  } else {
    window.location.href = `/story/${route.params.storyId}/chapter/${chapterId}`;
  }
};

// Récupérer le niveau de stress depuis localStorage au chargement
onMounted(() => {
  const savedStressLevel = localStorage.getItem('stressLevel');
  if (savedStressLevel) {
    stressLevel.value = parseInt(savedStressLevel);
  }
  
  fetchChapter();
});

// Surveiller les changements de route
watch(
  () => route.params,
  (newParams, oldParams) => {
    if (newParams.chapterId !== oldParams.chapterId) {
      fetchChapter();
    }
  },
  { deep: true }
);
</script>

<style scoped>
/* Styles précédents conservés */
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

.book-page {
  transition: all 0.3s ease;
  position: relative;
}

.choice-item {
  position: relative;
}

.stress-tip {
  position: absolute;
  bottom: -40px;
  left: 50%;
  transform: translateX(-50%);
  padding: 10px;
  background-color: #f0f0f0;
  border-radius: 5px;
  opacity: 0;
  transition: opacity 0.3s;
  pointer-events: none;
  white-space: nowrap;
}

.stress-tip .tip-text {
  visibility: hidden;
}

.choice-item:hover .stress-tip {
  opacity: 1;
  pointer-events: auto;
}

.choice-item:hover .tip-text {
  visibility: visible;
}

.stress-tip i {
  margin-right: 5px;
  color: #888;
}

@keyframes heartbeat {
  0% { transform: scale(1); }
  10% { transform: scale(1.01); }
  20% { transform: scale(1); }
  30% { transform: scale(1.01); }
  40% { transform: scale(1); }
  100% { transform: scale(1); }
}

@keyframes shake {
  0% { transform: translateX(0); }
  25% { transform: translateX(2px); }
  50% { transform: translateX(-2px); }
  75% { transform: translateX(2px); }
  100% { transform: translateX(0); }
}
</style>
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
    
      <div class="choice-list">
        <button 
          v-for="(choice, index) in choices" 
          :key="index" 
          @click="goToChapter(choice)"
          class="choice-button"
        >
          {{ choice.text }}
        </button>
      </div>

      <div class="info-section">
        <i class="fas fa-info-circle info-icon" @mouseover="showInfo = true" @mouseleave="showInfo = false"></i>
        <div v-if="showInfo" class="info-tooltip">
          {{ chapter?.stress_advice || 'Aucun conseil disponible' }}
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const chapter = ref({});
const choices = ref([]);
const showInfo = ref(false);
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
// Dans la méthode fetchChapter du composant Chapter.vue
const fetchChapter = async () => {
  const { storyId, chapterId } = route.params;
  
  try {
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    chapter.value = response.data;
    
    // Correction: s'assurer que nous utilisons next_chapter_id au lieu de next_chapter_number
    choices.value = response.data.choices.map(choice => ({
      text: choice.text,
      next_chapter_id: choice.next_chapter_id  // Utilisez le nom correct du champ
    }));

    stressLevel.value = response.data.stress_level || 5;
    
    localStorage.setItem('stressLevel', stressLevel.value);
  } catch (error) {
    console.error('Erreur de chargement du chapitre:', error);
  }
};

// Function to navigate to the next chapter
// Dans Chapter.vue
const goToChapter = (choice) => {
  if (!choice) {
    console.error('Choix invalide');
    return;
  }

  console.log('Navigating with choice:', choice);

  // Vérification de next_chapter_id (au lieu de next_chapter_number)
  if (choice.next_chapter_id === null || choice.next_chapter_id === undefined) {
    console.log('Pas de prochain chapitre détecté');
    const stressScore = localStorage.getItem('stressLevel') || 5;
    const outcome = stressScore >= 8 ? 'failure' : 'success';
    router.push(`/result/${outcome}`);
  } else {
    // Utiliser les paramètres actuels de la route
    const { storyId } = route.params;
    console.log(`Navigating to story/${storyId}/chapter/${choice.next_chapter_id}`);
    router.push(`/story/${storyId}/chapter/${choice.next_chapter_id}`);
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

.choice-list {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
  margin-top: 20px;
}

.choice-button {
  width: 100%;
  max-width: 400px;
  padding: 12px;
  background-color: #a5d6a7;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.choice-button:hover {
  background-color: #81c784;
}

.info-section {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  position: relative;
}

.info-icon {
  font-size: 1.5rem;
  color: #888;
  cursor: help;
}

.info-tooltip {
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  background-color: #333;
  color: white;
  padding: 10px;
  border-radius: 4px;
  max-width: 300px;
  text-align: center;
  z-index: 10;
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
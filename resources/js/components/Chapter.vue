<template>
  <main>
    <!-- Indicateur de chargement -->
    <div v-if="loading" class="loading-overlay">
      <div class="loading-spinner"></div>
      <div class="loading-text">Chargement du chapitre...</div>
    </div>
    
    <!-- Affichage des erreurs -->
    <div v-else-if="error" class="error-container">
      <div class="error-icon">⚠️</div>
      <div class="error-message">{{ error }}</div>
      <button @click="retryFetch" class="retry-button">Réessayer</button>
    </div>
    
    <div v-else class="book-page" :style="pageEffects">
      <StressMeter 
        :level="stressLevel" 
        :sleep-level="chapter?.current_sleep_level || 10" 
        :grades-level="chapter?.current_grades_level || 7" 
      />
      
      <h1>Chapitre {{ chapter?.chapter_number || '?' }}</h1>
      
      <p>{{ chapter?.content }}</p>
    
      <div class="choice-list">
        <button 
          v-for="(choice, index) in choices" 
          :key="index" 
          @click="makeChoice(choice)"
          class="choice-button"
          :class="{
            'stress-increase': getChoiceStressImpact(choice) > 0, 
            'stress-decrease': getChoiceStressImpact(choice) < 0,
            'sleep-increase': getChoiceSleepImpact(choice) > 0,
            'sleep-decrease': getChoiceSleepImpact(choice) < 0,
            'grades-increase': getChoiceGradesImpact(choice) > 0,
            'grades-decrease': getChoiceGradesImpact(choice) < 0
          }"
        >
          {{ choice.text }}
          <div class="choice-impact">
            <span v-if="getChoiceStressImpact(choice) !== 0" class="stress-impact">
              Stress: {{ getChoiceStressImpact(choice) > 0 ? '+' : '' }}{{ getChoiceStressImpact(choice) }}
            </span>
            <span v-if="getChoiceSleepImpact(choice) !== 0" class="sleep-impact">
              Sommeil: {{ getChoiceSleepImpact(choice) > 0 ? '+' : '' }}{{ getChoiceSleepImpact(choice) }}
            </span>
            <span v-if="getChoiceGradesImpact(choice) !== 0" class="grades-impact">
              Notes: {{ getChoiceGradesImpact(choice) > 0 ? '+' : '' }}{{ getChoiceGradesImpact(choice) }}
            </span>
          </div>
        </button>
      </div>

      <AdviceTooltip 
        :stress-advice="chapter?.stress_advice" 
        :sleep-advice="chapter?.sleep_advice" 
        :grades-advice="chapter?.grades_advice"
      />
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import StressMeter from './StressMeter.vue';
import AdviceTooltip from './adviceTooltip.vue';

const chapter = ref({});
const choices = ref([]);
const stressLevel = ref(0);
const route = useRoute();
const router = useRouter();
const loading = ref(true);
const error = ref(null);

// Computed property for page visual effects based on stress
const pageEffects = computed(() => {
  const level = stressLevel.value || 0;
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

// Function to get choice impact methods
const getChoiceStressImpact = (choice) => {
  const nextChapter = findNextChapter(choice);
  return nextChapter ? nextChapter.stress_impact || 0 : 0;
};

const getChoiceSleepImpact = (choice) => {
  const nextChapter = findNextChapter(choice);
  return nextChapter ? nextChapter.sleep_impact || 0 : 0;
};

const getChoiceGradesImpact = (choice) => {
  const nextChapter = findNextChapter(choice);
  return nextChapter ? nextChapter.grades_impact || 0 : 0;
};

const findNextChapter = (choice) => {
  if (choice.next_chapter_id) {
    // Trouvez le chapitre suivant dans les données de chapitre
    const nextChapter = chapter.value;
    return nextChapter;
  }
  return null;
};

// Function to retry fetching data
const retryFetch = () => {
  error.value = null;
  fetchChapter();
};

// Function to fetch chapter data
const fetchChapter = async () => {
  const { storyId, chapterId } = route.params;
  
  loading.value = true;
  error.value = null;
  
  try {
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    chapter.value = response.data;
    
    // Map choices with additional data
    choices.value = response.data.choices.map(choice => ({
      id: choice.id,
      text: choice.text,
      next_chapter_id: choice.next_chapter_id
    }));
    
    // Set stress level from chapter data
    if (response.data.current_stress_level !== undefined) {
      stressLevel.value = response.data.current_stress_level;
    } else {
      await fetchCurrentStress();
    }
    
  } catch (err) {
    console.error('Fetch chapter error details:', err);
    error.value = err.response?.data?.message || 'Erreur lors du chargement du chapitre';
  } finally {
    loading.value = false;
  }
};

// Récupérer le niveau de stress actuel
const fetchCurrentStress = async () => {
  try {
    const response = await axios.get('/api/stress');
    stressLevel.value = response.data.stress_level || 0;
    
    // Si burnout détecté, rediriger
    if (response.data.is_burnout) {
      router.push('/result/failure');
    }
  } catch (error) {
    console.error('Erreur de récupération du niveau de stress:', error);
  }
};

// Function to make a choice and update stress
const makeChoice = async (choice) => {
  try {
    loading.value = true;
    
    if (!choice.id) {
      console.error('ID de choix manquant');
      return;
    }
    
    // Mettre à jour le niveau de stress via l'API
    const response = await axios.post('/api/stress/update', {
      choice_id: choice.id
    });
    
    // Mettre à jour le niveau de stress local
    stressLevel.value = response.data.stress_level || stressLevel.value;
    
    // Si burnout détecté, rediriger vers la page d'échec
    if (response.data.is_burnout) {
      router.push('/result/failure');
      return;
    }
    
    // Navigation vers le chapitre suivant
    if (!choice.next_chapter_id) {
      // Si on est sur le chapitre burnout (99), toujours rediriger vers failure
      if (chapter.value.chapter_number === 99) {
        router.push('/result/failure');
      } else {
        // Sinon, c'est une fin normale basée sur le niveau de stress
        const outcome = stressLevel.value >= 8 ? 'warning' : 'success';
        router.push(`/result/${outcome}`);
      }
    } else {
      // Sinon, aller au chapitre suivant
      const { storyId } = route.params;
      router.push(`/story/${storyId}/chapter/${choice.next_chapter_id}`);
    }
  } catch (error) {
    console.error('Erreur lors du choix:', error);
    error.value = error.response?.data?.message || 'Erreur lors du choix';
  } finally {
    loading.value = false;
  }
};

// Récupérer le niveau de stress depuis la session au chargement
onMounted(() => {
  loading.value = true;
  fetchCurrentStress()
    .then(() => fetchChapter())
    .then(() => {
      // Si c'est le chapitre 99, forcer le niveau de stress à 10
      if (chapter.value && chapter.value.chapter_number === 99) {
        stressLevel.value = 10;
      }
    })
    .catch(err => {
      console.error('Error during initial data load:', err);
      error.value = err.message || 'Une erreur s\'est produite';
    })
    .finally(() => {
      loading.value = false;
    });
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
/* Styles existants précédemment dans Chapter.vue */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #a5d6a7;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.loading-text {
  margin-top: 20px;
  font-size: 1.2rem;
  color: #333;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.error-container {
  background-color: #ffebee;
  border: 1px solid #ef9a9a;
  border-radius: 8px;
  padding: 20px;
  max-width: 500px;
  margin: 40px auto;
  text-align: center;
}

.error-icon {
  font-size: 3rem;
  margin-bottom: 15px;
}

.error-message {
  color: #c62828;
  margin-bottom: 20px;
}

.retry-button {
  background-color: #ef5350;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.retry-button:hover {
  background-color: #d32f2f;
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
  position: relative;
}

.choice-button:hover {
  background-color: #81c784;
}

.choice-impact {
  display: flex;
  justify-content: space-between;
  margin-top: 5px;
  font-size: 0.8rem;
  color: #666;
}

.stress-impact {
  color: #ef5350;
}

.sleep-impact {
  color: #4caf50;
}

.grades-impact {
  color: #2196f3;
}

.choice-button.stress-increase {
  border-left: 4px solid #ef5350;
}

.choice-button.stress-decrease {
  border-left: 4px solid #4caf50;
}

.choice-button.sleep-increase {
  border-right: 4px solid #4caf50;
}

.choice-button.sleep-decrease {
  border-right: 4px solid #ef5350;
}

.choice-button.grades-increase {
  border-bottom: 4px solid #4caf50;
}

.choice-button.grades-decrease {
  border-bottom: 4px solid #ef5350;
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
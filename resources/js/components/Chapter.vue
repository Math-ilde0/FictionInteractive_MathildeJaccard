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
      <StressMeter :level="stressLevel" />
      
      <h1>Chapitre {{ chapter?.chapter_number || '?' }}</h1>
      
      <p>{{ chapter?.content }}</p>
    
      <div class="choice-list">
        <button 
          v-for="(choice, index) in choices" 
          :key="index" 
          @click="makeChoice(choice)"
          class="choice-button"
          :class="{ 'stress-increase': getChoiceStressImpact(choice) > 0, 'stress-decrease': getChoiceStressImpact(choice) < 0 }"
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
import StressMeter from './StressMeter.vue';

const chapter = ref({});
const choices = ref([]);
const showInfo = ref(false);
const stressLevel = ref(0);
const showStressImpact = ref(true); // Option pour afficher l'impact de stress des choix
const route = useRoute();
const router = useRouter();
const loading = ref(true); // État pour le chargement
const error = ref(null); // État pour les erreurs

// Map pour stocker les valeurs d'impact de stress pour chaque choix
const choiceStressImpacts = ref(new Map());

// Computed property pour les effets visuels de stress
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

// Function to get stress impact for a choice
const getChoiceStressImpact = (choice) => {
  // Si nous avons un impact de stress stocké pour ce choix, l'utiliser
  if (choiceStressImpacts.value.has(choice.id)) {
    return choiceStressImpacts.value.get(choice.id);
  }
  return 0; // Par défaut, pas d'impact
};

// Sauvegarder la progression dans localStorage
const saveProgress = () => {
  localStorage.setItem('storyProgress', JSON.stringify({
    storyId: route.params.storyId,
    chapterId: route.params.chapterId,
    stressLevel: stressLevel.value
  }));
};

// Charger la progression sauvegardée
const loadProgress = () => {
  const savedProgress = localStorage.getItem('storyProgress');
  if (savedProgress) {
    try {
      const progress = JSON.parse(savedProgress);
      if (progress.storyId && progress.chapterId) {
        return progress;
      }
    } catch (e) {
      console.error('Erreur lors du chargement de la progression:', e);
    }
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
  
  loading.value = true; // Commencer le chargement
  error.value = null; // Réinitialiser les erreurs
  
  try {
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    chapter.value = response.data;
    
    // Map choices with additional data
    choices.value = response.data.choices.map(choice => ({
      id: choice.id,
      text: choice.text,
      next_chapter_id: choice.next_chapter_id
    }));
    
    // Si le serveur nous envoie un niveau de stress actuel, l'utiliser
    if (response.data.current_stress_level !== undefined) {
      stressLevel.value = response.data.current_stress_level;
    } else {
      // Sinon, obtenir le niveau de stress actuel via l'API
      fetchCurrentStress();
    }

    // Récupérer les valeurs d'impact de stress pour chaque choix
    fetchChoiceStressImpacts();
    
    // Sauvegarder la progression après chargement du chapitre
    saveProgress();
    
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors du chargement du chapitre';
    console.error('Erreur de chargement du chapitre:', err);
  } finally {
    loading.value = false; // Terminer le chargement
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

// Fetch stress impacts for all choices in the current chapter
const fetchChoiceStressImpacts = async () => {
  const fetchedImpacts = new Map();
  
  try {
    // Pour chaque choix, récupérer le chapitre suivant pour connaître son impact de stress
    for (const choice of choices.value) {
      if (choice.next_chapter_id) {
        const nextChapter = await fetchChapterInfo(choice.next_chapter_id);
        if (nextChapter && nextChapter.stress_impact !== undefined) {
          fetchedImpacts.set(choice.id, nextChapter.stress_impact);
        }
      }
    }
    
    choiceStressImpacts.value = fetchedImpacts;
  } catch (error) {
    console.error('Erreur de récupération des impacts de stress:', error);
  }
};

// Fetch basic info about a chapter
const fetchChapterInfo = async (chapterId) => {
  try {
    const { storyId } = route.params;
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    return response.data;
  } catch (error) {
    console.error(`Erreur de récupération du chapitre ${chapterId}:`, error);
    return null;
  }
};

// Function to make a choice and update stress
// Function to make a choice and update stress
const makeChoice = async (choice) => {
  try {
    loading.value = true; // Montrer le chargement pendant l'action
    
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
    loading.value = false; // Cacher le chargement
  }
};

// Récupérer le niveau de stress depuis la session au chargement
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
      error.value = err.message || 'Une erreur s\'est produite';
    })
    .finally(() => {
      loading.value = false;
    });
});

// Surveiller les changements de route et sauvegarder la progression
watch(
  () => route.params,
  (newParams, oldParams) => {
    if (newParams.chapterId !== oldParams.chapterId) {
      fetchChapter();
    }
  },
  { deep: true }
);

// Surveiller les changements de niveau de stress pour sauvegarder la progression
watch(
  stressLevel,
  () => {
    saveProgress();
  }
);
</script>

<style scoped>
/* Styles pour l'indicateur de chargement */
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

/* Styles pour l'affichage des erreurs */
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

.stress-increase {
  border-left: 4px solid #ef5350; /* Bordure rouge pour les choix qui augmentent le stress */
}

.stress-decrease {
  border-left: 4px solid #66bb6a; /* Bordure verte pour les choix qui diminuent le stress */
}

.stress-impact {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 0.8rem;
  padding: 2px 6px;
  border-radius: 10px;
  background-color: rgba(0, 0, 0, 0.1);
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
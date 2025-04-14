<template>
  <main>
    <div class="book-page" :style="pageEffects">
      <div class="stress-container">
        <div class="stress-meter">
          <div class="stress-text">Niveau de stress: {{ stressLevel }}/10</div>
          <div class="stress-bar">
            <div
              class="stress-fill"
              :style="{ width: `${stressLevel * 10}%`, backgroundColor: stressColor }"
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
          @click="makeChoice(choice)"
          class="choice-button"
          :class="{ 'stress-increase': getChoiceStressImpact(choice) > 0, 'stress-decrease': getChoiceStressImpact(choice) < 0 }"
        >
          {{ choice.text }}
          <span v-if="showStressImpact && getChoiceStressImpact(choice) !== 0" class="stress-impact">
            {{ getChoiceStressImpact(choice) > 0 ? '+' : '' }}{{ getChoiceStressImpact(choice) }} stress
          </span>
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
const stressLevel = ref(0);
const showStressImpact = ref(true); // Option pour afficher l'impact de stress des choix
const route = useRoute();
const router = useRouter();

// Map pour stocker les valeurs d'impact de stress pour chaque choix
const choiceStressImpacts = ref(new Map());

// Computed property for stress color
const stressColor = computed(() => {
  const level = stressLevel.value || 0;
  if (level <= 3) return '#a5d6a7'; // Vert pour stress faible
  if (level <= 7) return '#ffd54f'; // Jaune pour stress moyen
  return '#ef5350'; // Rouge pour stress élevé
});

// Computed property for stress emoji
const stressEmoji = computed(() => {
  const level = stressLevel.value || 0;
  if (level <= 3) return '😌'; // Détendu
  if (level <= 5) return '😐'; // Neutre
  if (level <= 7) return '😓'; // Inquiet
  if (level <= 9) return '😰'; // Très stressé
  return '🤯'; // Burnout imminent
});

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

// Function to fetch chapter data
const fetchChapter = async () => {
  const { storyId, chapterId } = route.params;
  
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
    
  } catch (error) {
    console.error('Erreur de chargement du chapitre:', error);
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
const makeChoice = async (choice) => {
  try {
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
      // Si pas de chapitre suivant, c'est la fin de l'histoire
      const outcome = stressLevel.value >= 8 ? 'failure' : 'success';
      router.push(`/result/${outcome}`);
    } else {
      // Sinon, aller au chapitre suivant
      const { storyId } = route.params;
      router.push(`/story/${storyId}/chapter/${choice.next_chapter_id}`);
    }
  } catch (error) {
    console.error('Erreur lors du choix:', error);
  }
};

// Récupérer le niveau de stress depuis la session au chargement
onMounted(() => {
  fetchCurrentStress();
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
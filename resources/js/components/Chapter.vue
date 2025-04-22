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
      <!-- Nouvelles jauges pour les 3 métriques -->
      <div class="metrics-container">
        <div class="metric">
          <div class="metric-title">Charge Mentale</div>
          <div class="metric-bar">
            <div class="metric-fill charge-mental" :style="{ width: `${chargeMentale * 10}%` }"></div>
          </div>
          <div class="metric-value">{{ chargeMentale }}/10</div>
        </div>
        
        <div class="metric">
          <div class="metric-title">Sommeil</div>
          <div class="metric-bar">
            <div class="metric-fill sleep" :style="{ width: `${sommeil * 10}%` }"></div>
          </div>
          <div class="metric-value">{{ sommeil }}/10</div>
        </div>
        
        <div class="metric">
          <div class="metric-title">Notes</div>
          <div class="metric-bar">
            <div class="metric-fill grades" :style="{ width: `${notes * 10}%` }"></div>
          </div>
          <div class="metric-value">{{ notes }}/10</div>
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
          :class="getChoiceClasses(choice)"
        >
          {{ choice.text }}
        </button>
      </div>

      <div class="info-section">
        <div class="advice-toggle" @click="toggleAdvice">
          <i class="fas fa-info-circle"></i> 
          <span>{{ showAdvice ? 'Masquer les conseils' : 'Voir les conseils' }}</span>
        </div>
        
        <div v-if="showAdvice" class="advice-container">
          <div v-if="chapter?.stress_advice" class="advice-item">
            <h4>Conseil pour la charge mentale :</h4>
            <p>{{ chapter.stress_advice }}</p>
          </div>
          
          <div v-if="chapter?.sleep_advice" class="advice-item">
            <h4>Conseil pour le sommeil :</h4>
            <p>{{ chapter.sleep_advice }}</p>
          </div>
          
          <div v-if="chapter?.grades_advice" class="advice-item">
            <h4>Conseil pour les études :</h4>
            <p>{{ chapter.grades_advice }}</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { setCookie, getCookie } from '@/utils/cookies';

const chapter = ref({});
const choices = ref([]);
const showAdvice = ref(false);
const route = useRoute();
const router = useRouter();
const loading = ref(true);
const error = ref(null);

// Métriques
const chargeMentale = ref(0);
const sommeil = ref(10);
const notes = ref(7);

// Map pour stocker les valeurs d'impact pour chaque choix
const choiceImpacts = ref(new Map());

// Computed property pour les effets visuels selon la charge mentale
const pageEffects = computed(() => {
  const level = chargeMentale.value || 0;
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

// Fonction pour obtenir les classes CSS correspondant aux impacts du choix
const getChoiceClasses = (choice) => {
  if (!choiceImpacts.value.has(choice.id)) return {};
  
  const impacts = choiceImpacts.value.get(choice.id);
  const classes = [];
  
  if (impacts.stress_impact > 0) classes.push('charge-increase');
  if (impacts.stress_impact < 0) classes.push('charge-decrease');
  
  if (impacts.sleep_impact < 0) classes.push('sleep-decrease');
  if (impacts.sleep_impact > 0) classes.push('sleep-increase');
  
  if (impacts.grades_impact < 0) classes.push('grades-decrease');
  if (impacts.grades_impact > 0) classes.push('grades-increase');
  
  return classes;
};

// Toggle pour afficher/masquer les conseils
const toggleAdvice = () => {
  showAdvice.value = !showAdvice.value;
};

// Sauvegarder la progression dans localStorage
const saveProgress = () => {
  localStorage.setItem('storyProgress', JSON.stringify({
    storyId: route.params.storyId,
    chapterId: route.params.chapterId,
    chargeMentale: chargeMentale.value,
    sommeil: sommeil.value,
    notes: notes.value
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
  
  loading.value = true;
  error.value = null;
  
  try {
    console.log(`Fetching chapter: /api/story/${storyId}/chapter/${chapterId}`);
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    console.log('Chapter data received:', response.data);
    chapter.value = response.data;
    
    // Map choices with additional data
    choices.value = response.data.choices.map(choice => ({
      id: choice.id,
      text: choice.text,
      next_chapter_id: choice.next_chapter_id
    }));
    
    // Utiliser les métriques de la réponse si disponibles
    if (response.data.current_stress_level !== undefined) {
      chargeMentale.value = response.data.current_stress_level;
    }
    
    if (response.data.current_sleep_level !== undefined) {
      sommeil.value = response.data.current_sleep_level;
    }
    
    if (response.data.current_grades_level !== undefined) {
      notes.value = response.data.current_grades_level;
    }
    
    // Récupérer les impacts des choix
    await fetchChoiceImpacts();
    
    // Sauvegarder la progression
    saveProgress();
    
    // Vérifier si des avertissements doivent être affichés
    checkWarnings();
    
  } catch (err) {
    console.error('Fetch chapter error details:', err);
    error.value = err.response?.data?.message || 'Erreur lors du chargement du chapitre';
  } finally {
    loading.value = false;
  }
};

// Récupérer les impacts des choix
const fetchChoiceImpacts = async () => {
  const impactsMap = new Map();
  
  try {
    for (const choice of choices.value) {
      if (choice.next_chapter_id) {
        const nextChapter = await fetchChapterInfo(choice.next_chapter_id);
        if (nextChapter) {
          impactsMap.set(choice.id, {
            stress_impact: nextChapter.stress_impact || 0,
            sleep_impact: nextChapter.sleep_impact || 0,
            grades_impact: nextChapter.grades_impact || 0
          });
        }
      }
    }
    
    choiceImpacts.value = impactsMap;
  } catch (error) {
    console.error('Erreur de récupération des impacts:', error);
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

// Vérifier si des avertissements ou redirection sont nécessaires
const checkWarnings = () => {
  // Vérification de Burn-out (charge mentale à 10 ou plus)
  if (chargeMentale.value >= 10) {
    router.push('/result/failure');
    return;
  }
  
  // Vérification de fatigue extrême (sommeil à 0 ou moins)
  if (sommeil.value <= 0) {
    router.push('/result/sleep-crisis');
    return;
  }
  
  // Vérification d'échec académique (notes à 0 ou moins)
  if (notes.value <= 0) {
    router.push('/result/academic-crisis');
    return;
  }
  
  // Vérifier les contraintes de chapitre (le chapitre exige un certain niveau)
  if (chapter.value.min_sleep_level && sommeil.value < chapter.value.min_sleep_level) {
    // Afficher un avertissement sur le sommeil
    alert(`Attention : Votre niveau de sommeil est trop bas pour ce chapitre. 
           Votre personnage risque de s'endormir en cours !`);
  }
  
  if (chapter.value.min_grades_level && notes.value < chapter.value.min_grades_level) {
    // Afficher un avertissement sur les notes
    alert(`Attention : Vos notes sont trop basses pour ce chapitre. 
           Votre progression académique est en danger !`);
  }
};
// Function to make a choice and update metrics
// Function to make a choice and update metrics
const makeChoice = async (choice) => {
  try {
    loading.value = true;
    
    if (!choice.id) {
      console.error('ID de choix manquant');
      return;
    }
    
    console.log(`Making choice ${choice.id}`);
    console.log('Métriques avant choix:', {
      chargeMentale: chargeMentale.value,
      sommeil: sommeil.value,
      notes: notes.value
    });
    
    // Mettre à jour les métriques via l'API
    console.log('Envoi de la requête à /api/metrics/update');
    const response = await axios.post('/api/metrics/update', {
      choice_id: choice.id
    });
    
    console.log('Response received:', response);
    console.log('Choice update response data:', response.data);
    
    // Mettre à jour les métriques locales
    const oldStress = chargeMentale.value;
    const oldSleep = sommeil.value;
    const oldGrades = notes.value;
    
    chargeMentale.value = response.data.stress_level;
    sommeil.value = response.data.sleep_level;
    notes.value = response.data.grades_level;
    
    console.log('Métriques après mise à jour:', {
      chargeMentale: chargeMentale.value, 
      sommeil: sommeil.value, 
      notes: notes.value
    });
    console.log('Différences:', {
      stress: chargeMentale.value - oldStress,
      sleep: sommeil.value - oldSleep,
      grades: notes.value - oldGrades  
    });
    
    
    setCookie('stress_level', chargeMentale.value);
setCookie('sleep_level', sommeil.value);
setCookie('grades_level', notes.value);
    
    // Vérification des situations spéciales
    if (response.data.is_burnout) {
      console.log('Burnout détecté, redirection vers /result/failure');
      router.push('/result/failure');
      return;
    }
    
    if (response.data.sleep_crisis) {
      console.log('Crise de sommeil détectée, redirection vers /result/sleep-crisis');
      router.push('/result/sleep-crisis');
      return;
    }
    
    if (response.data.academic_crisis) {
      console.log('Crise académique détectée, redirection vers /result/academic-crisis');
      router.push('/result/academic-crisis');
      return;
    }
    
    // Navigation vers le chapitre suivant
    if (!choice.next_chapter_id) {
      console.log('Pas de chapitre suivant spécifié');
      // Si on est sur le chapitre 99 (burnout), rediriger vers failure
      if (chapter.value.chapter_number === 99) {
        console.log('Chapitre 99 (burnout), redirection vers /result/failure');
        router.push('/result/failure');
      } else {
        // Sinon, c'est une fin normale basée sur le niveau de stress
        const outcome = chargeMentale.value >= 8 ? 'warning' : 'success';
        console.log(`Fin normale, niveau de stress ${chargeMentale.value}, redirection vers /result/${outcome}`);
        router.push(`/result/${outcome}`);
      }
    } else {
      // Aller au chapitre suivant
      const { storyId } = route.params;
      console.log(`Navigation vers le chapitre suivant: /story/${storyId}/chapter/${choice.next_chapter_id}`);
      router.push(`/story/${storyId}/chapter/${choice.next_chapter_id}`);
    }
  } catch (error) {
    console.error('Erreur lors du choix:', error);
    
    // Afficher les détails de l'erreur pour le débogage
    if (error.response) {
      console.error('Détails de l\'erreur de réponse:', {
        status: error.response.status,
        headers: error.response.headers,
        data: error.response.data
      });
    } else if (error.request) {
      console.error('La requête a été faite mais pas de réponse reçue:', error.request);
    } else {
      console.error('Erreur lors de la configuration de la requête:', error.message);
    }
    
    error.value = error.response?.data?.message || 'Erreur lors du choix';
  } finally {
    loading.value = false;
  }
};

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


// Surveiller les changements de métriques pour sauvegarder la progression
watch(
  [chargeMentale, sommeil, notes],
  () => {
    saveProgress();
    checkWarnings();
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

/* Conteneur pour les métriques */
.metrics-container {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
}

.metric {
  display: flex;
  align-items: center;
  gap: 10px;
}

.metric-title {
  width: 120px;
  font-weight: bold;
  font-size: 0.9rem;
}

.metric-bar {
  flex-grow: 1;
  height: 10px;
  background-color: #e0e0e0;
  border-radius: 5px;
  overflow: hidden;
}

.metric-fill {
  height: 100%;
  transition: width 0.5s ease;
}

.metric-fill.charge-mental {
  background-color: #ef5350;
}

.metric-fill.sleep {
  background-color: #42a5f5;
}

.metric-fill.grades {
  background-color: #66bb6a;
}

.metric-value {
  width: 40px;
  text-align: right;
  font-size: 0.9rem;
  font-weight: bold;
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
  text-align: left;
}

.choice-button:hover {
  background-color: #81c784;
}

.charge-increase {
  border-left: 4px solid #ef5350;
}

.charge-decrease {
  border-left: 4px solid #66bb6a;
}

.sleep-decrease {
  border-right: 4px solid #ef5350;
}

.sleep-increase {
  border-right: 4px solid #66bb6a;
}

.grades-decrease::after {
  content: "↓";
  position: absolute;
  right: 10px;
  color: #ef5350;
}

.grades-increase::after {
  content: "↑";
  position: absolute;
  right: 10px;
  color: #66bb6a;
}

.advice-toggle {
  cursor: pointer;
  color: #555;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  margin: 20px 0;
  padding: 5px 10px;
  background-color: #f0f0f0;
  border-radius: 4px;
  transition: background-color 0.2s;
}

.advice-toggle:hover {
  background-color: #e0e0e0;
}

.advice-container {
  margin-top: 10px;
  padding: 15px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.advice-item {
  margin-bottom: 15px;
}

.advice-item h4 {
  margin: 0 0 5px 0;
  color: #555;
}

.advice-item p {
  margin: 0;
  font-style: italic;
  font-size: 0.95rem;
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
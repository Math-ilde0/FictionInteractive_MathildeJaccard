<template>
  <main>
    <!-- Bouton retour à l'accueil -->
    <div class="fixed top-5 right-5 z-50">
      <button 
        @click="confirmReturnHome" 
        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow flex items-center gap-2"
      >
        <span>🏠</span> Accueil
      </button>
    </div>
    <!-- Indicateur de chargement -->
    <div v-if="loading" class="fixed inset-0 bg-white/80 flex flex-col justify-center items-center z-50">
      <div class="w-12 h-12 border-4 border-gray-200 border-t-green-300 rounded-full animate-spin"></div>
      <div class="mt-4 text-lg text-gray-700">Chargement du chapitre...</div>
    </div>

    <!-- Affichage des erreurs -->
    <div v-else-if="error" class="max-w-lg mx-auto mt-20 p-6 bg-red-100 border border-red-300 rounded-lg text-center">
      <div class="text-4xl mb-4">⚠️</div>
      <div class="text-red-700 font-semibold mb-4">{{ error }}</div>
      <button @click="retryFetch" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
        Réessayer
      </button>
    </div>

    <!-- Page du chapitre -->
    <div v-else class="transition-all p-6 relative" :style="pageEffects">
      <MetricsDisplay :level="chargeMentale" :sleepLevel="sommeil" :gradesLevel="notes" />

      <h1 class="text-3xl font-bold text-center mb-6">Chapitre {{ chapter?.chapter_number || '?' }}</h1>
      
      <p class="text-gray-700 leading-relaxed mb-8 whitespace-pre-line">{{ chapter?.content }}</p>

      <div class="flex flex-col items-center gap-4">
        <button
          v-for="(choice, index) in choices"
          :key="index"
          @click="makeChoice(choice)"
          class="w-full max-w-md px-6 py-3 bg-green-300 text-white rounded-lg hover:bg-green-400 transition relative text-left"
          :class="getChoiceClasses(choice)"
        >
          {{ choice.text }}
        </button>
      </div>

      <AdviceTooltip
        v-if="chapter && (chapter.stress_advice || chapter.sleep_advice || chapter.grades_advice)"
        :stressAdvice="chapter.stress_advice || ''"
        :sleepAdvice="chapter.sleep_advice || ''"
        :gradesAdvice="chapter.grades_advice || ''"
        class="mt-10"
      />
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import AdviceTooltip from '@/components/AdviceTooltip.vue';
import MetricsDisplay from '@/components/MetricsDisplay.vue' 
import { setMetric, getMetric } from '@/utils/metrics';


const chapter = ref({});
const choices = ref([]);
const showAdvice = ref(false);
const route = useRoute();
const router = useRouter();
const loading = ref(true);
const error = ref(null);

// Métriques
const chargeMentale = ref(3);
const sommeil = ref(7);
const notes = ref(6);

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
// Fonction pour confirmer le retour à l'accueil
const confirmReturnHome = () => {
  if (confirm("Êtes-vous sûr de vouloir retourner à l'accueil ? Votre progression sera sauvegardée mais vous quitterez le chapitre actuel.")) {
    // Sauvegarder la progression avant de quitter
    saveProgress();
    // Rediriger vers la page d'accueil
    router.push('/');
  }
};
// Function to fetch chapter data
const fetchChapter = async () => {
  const { storyId, chapterId } = route.params;

  loading.value = true;
  error.value = null;

  try {
const response = await axios.get(`/story/${storyId}/chapter/${chapterId}`);


    
    chapter.value = response.data;
    choices.value = response.data.choices || []; // 🆕 pour afficher les boutons
  } catch (err) {
    console.error('Fetch chapter error:', err);
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
        try {
          const nextChapter = await fetchChapterInfo(choice.next_chapter_id);
          if (nextChapter) {
            impactsMap.set(choice.id, {
              stress_impact: nextChapter.stress_impact || 0,
              sleep_impact: nextChapter.sleep_impact || 0,
              grades_impact: nextChapter.grades_impact || 0
            });
          }
        } catch (innerError) {
          console.error(`Erreur pour le choix ${choice.id}:`, innerError);
          // Continue with other choices even if one fails
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
    const response = await axios.get(`/story/${storyId}/chapter/${chapterId}`);
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
};
// Function to make a choice and update metrics
// Modification de la méthode makeChoice dans resources/js/components/Chapter.vue
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
    
    // Obtenir les métriques stockées dans localStorage
    const currentStress = getMetric('stress_level', chargeMentale.value);
    const currentSleep = getMetric('sleep_level', sommeil.value);
    const currentGrades = getMetric('grades_level', notes.value);
    
    // Envoyer l'ID du choix ET les métriques actuelles depuis localStorage
    const response = await axios.post('/metrics/update', {
      choice_id: choice.id,
      stress_level: currentStress,
      sleep_level: currentSleep,
      grades_level: currentGrades
    });
    
    console.log('Response received:', response);
    console.log('Choice update response data:', response.data);
    
    // Mettre à jour les métriques locales avec les valeurs renvoyées par le serveur
    chargeMentale.value = response.data.stress_level;
    sommeil.value = response.data.sleep_level;
    notes.value = response.data.grades_level;
    
    console.log('Métriques après mise à jour:', {
      chargeMentale: chargeMentale.value, 
      sommeil: sommeil.value, 
      notes: notes.value
    });
    
    // Mettre à jour localStorage avec les nouvelles valeurs
    setMetric('stress_level', chargeMentale.value);
    setMetric('sleep_level', sommeil.value);
    setMetric('grades_level', notes.value);
    
    // Sauvegarder la progression dans localStorage
    saveProgress();
    
    // Vérification des situations spéciales
    if (response.data.is_burnout || chargeMentale.value >= 10) {
      console.log('Burnout détecté, redirection vers /result/failure');
      router.push('/result/failure');
      return;
    }
    
    if (response.data.sleep_crisis || sommeil.value <= 0) {
      console.log('Crise de sommeil détectée, redirection vers /result/sleep-crisis');
      router.push('/result/sleep-crisis');
      return;
    }
    
    if (response.data.academic_crisis || notes.value <= 0) {
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
onMounted(async () => {
  // Si c'est le premier chapitre, réinitialiser les métriques
  if (route.params.chapterId === '1') {
    await axios.post('/metrics/reset');
    
    // Définir manuellement les métriques par défaut
    chargeMentale.value = 3;
    sommeil.value = 7;
    notes.value = 6;
    
    // Sauvegarder dans localStorage
    setMetric('stress_level', chargeMentale.value);
    setMetric('sleep_level', sommeil.value);
    setMetric('grades_level', notes.value);
  }
  
  // Puis charger le chapitre
  fetchChapter();
});


</script>

<style scoped>


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
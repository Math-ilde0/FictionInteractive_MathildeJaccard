<!--
/**
 * @component Chapter.vue
 * Affiche un chapitre du jeu avec son contenu et ses choix possibles.
 *
 * Gère :
 * - récupération des données via `/story/:id/chapter/:id`
 * - application des impacts sur les métriques
 * - sauvegarde de la progression locale
 * - redirections selon les seuils atteints
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <!-- Bouton de retour à l'accueil -->
  <div class="fixed top-5 left-5 z-50">
    <button @click="confirmReturnHome" class="px-4 py-2 bg-white hover:bg-blue-200 text-white rounded-lg shadow flex items-center gap-2">
      <span>🏠</span>
    </button>
  </div>

  <!-- Indicateur de chargement -->
  <div v-if="loading && !suppressLoading" class="fixed inset-0 bg-white/80 flex flex-col justify-center items-center z-50">
    <div class="w-12 h-12 border-4 border-gray-200 border-t-green-300 rounded-full animate-spin"></div>
    <div class="mt-4 text-lg text-gray-700">Chargement du chapitre...</div>
  </div>

  <!-- Affichage du chapitre -->
  <div
    v-else-if="!error"
    :style="pageEffects"
    class="bg-white max-w-3xl mx-auto shadow-xl rounded-lg px-10 py-12 relative font-serif leading-relaxed text-gray-800 prose prose-lg"
  >
    <!-- Affichage des métriques -->
    <MetricsDisplay :level="chargeMentale" :sleepLevel="sommeil" :gradesLevel="notes" />

    <h1 class="text-4xl font-bold text-center mb-8 tracking-wide">Chapitre {{ chapter?.chapter_number || '?' }}</h1>

    <p class="text-gray-700 leading-relaxed mb-8 whitespace-pre-line">{{ chapter?.content }}</p>

    <!-- Affichage des choix -->
    <div class="flex flex-col items-center gap-4">
      <button
        v-for="(choice, index) in choices"
        :key="index"
        @click="makeChoice(choice)"
        class="w-full max-w-md px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition relative text-left"
        :class="getChoiceClasses(choice)"
      >
        {{ choice.text }}
      </button>
    </div>

    <!-- Affichage des conseils -->
    <AdviceTooltip
      v-if="chapter && (chapter.stress_advice || chapter.sleep_advice || chapter.grades_advice)"
      :stressAdvice="chapter.stress_advice || ''"
      :sleepAdvice="chapter.sleep_advice || ''"
      :gradesAdvice="chapter.grades_advice || ''"
      class="mt-10"
    />
  </div>
</template>

<script setup>
//  Imports Vue
import { ref, onMounted, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

// Composants personnalisés
import AdviceTooltip from '@/components/ui/AdviceTooltip.vue';
import MetricsDisplay from '@/components/ui/MetricsDisplay.vue';

// Fonctions utilitaires
import { setMetric, getMetric } from '@/utils/metrics';
import { showNotification } from '@/stores/notificationStore';

// Données réactives
const chapter = ref({});
const choices = ref([]);
const currentChapterId = ref(1);
const loading = ref(true);
const error = ref(null);
const suppressLoading = ref(false);
const chargeMentale = ref(3);
const sommeil = ref(7);
const notes = ref(6);
const choiceImpacts = ref(new Map());

// Routing
const route = useRoute();
const router = useRouter();

// Effets visuels selon le niveau de stress
const pageEffects = computed(() => {
  const level = chargeMentale.value;
  if (level <= 3) return {};
  if (level <= 6) return { boxShadow: '0 8px 20px rgba(255, 213, 79, 0.2)' };
  if (level <= 8) return { boxShadow: '0 8px 20px rgba(239, 83, 80, 0.3)', animation: 'heartbeat 3s infinite' };
  return { boxShadow: '0 8px 20px rgba(239, 83, 80, 0.5)', animation: 'shake 0.5s infinite' };
});

// Classes visuelles pour les choix en fonction de l’impact
const getChoiceClasses = (choice) => {
  const impacts = choiceImpacts.value.get(choice.id);
  if (!impacts) return {};

  const classes = [];
  if (impacts.stress_impact > 0) classes.push('charge-increase');
  if (impacts.stress_impact < 0) classes.push('charge-decrease');
  if (impacts.sleep_impact < 0) classes.push('sleep-decrease');
  if (impacts.sleep_impact > 0) classes.push('sleep-increase');
  if (impacts.grades_impact < 0) classes.push('grades-decrease');
  if (impacts.grades_impact > 0) classes.push('grades-increase');
  return classes;
};

// Charger un chapitre depuis l’API
const fetchChapter = async (chapterId = currentChapterId.value) => {
  const { storyId } = route.params;
  if (!suppressLoading.value) loading.value = true;

  try {
    const response = await axios.get(`/story/${storyId}/chapter/${chapterId}`, {
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    });
    chapter.value = response.data;
    choices.value = response.data.choices || [];
    fetchChoiceImpacts();
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur de chargement';
  } finally {
    loading.value = false;
  }
};

// Prédit l’impact des choix sur les métriques
const fetchChoiceImpacts = async () => {
  const impactsMap = new Map();
  for (const choice of choices.value) {
    const next = await fetchChapterInfo(choice.next_chapter_id);
    if (next) {
      impactsMap.set(choice.id, {
        stress_impact: next.stress_impact || 0,
        sleep_impact: next.sleep_impact || 0,
        grades_impact: next.grades_impact || 0
      });
    }
  }
  choiceImpacts.value = impactsMap;
};

// Obtenir les infos d’un chapitre par ID
const fetchChapterInfo = async (chapterId) => {
  const { storyId } = route.params;
  try {
    const response = await axios.get(`/story/${storyId}/chapter/${chapterId}`);
    return response.data;
  } catch {
    return null;
  }
};

// Si une métrique atteint un seuil critique, rediriger vers la page de résultat
const checkWarnings = () => {
  if (chargeMentale.value >= 10) router.push('/result/failure');
  else if (sommeil.value <= 0) router.push('/result/sleep-crisis');
  else if (notes.value <= 0) router.push('/result/academic-crisis');
};

// Lorsqu’un choix est fait
const makeChoice = async (choice) => {
  suppressLoading.value = true;
  try {
    const response = await axios.post('/metrics/update', {
      choice_id: choice.id,
      stress_level: getMetric('stress_level', chargeMentale.value),
      sleep_level: getMetric('sleep_level', sommeil.value),
      grades_level: getMetric('grades_level', notes.value)
    });

    chargeMentale.value = response.data.stress_level;
    sommeil.value = response.data.sleep_level;
    notes.value = response.data.grades_level;

    setMetric('stress_level', chargeMentale.value);
    setMetric('sleep_level', sommeil.value);
    setMetric('grades_level', notes.value);

    saveProgress();
    checkWarnings();

    if (!choice.next_chapter_id) {
      const outcome = chargeMentale.value >= 8 ? 'warning' : 'success';
      router.push(`/result/${outcome}`);
    } else {
      currentChapterId.value = choice.next_chapter_id;
    }
  } catch {
    showNotification({ type: 'error', message: 'Erreur lors du choix', duration: 3000 });
  } finally {
    suppressLoading.value = false;
  }
};

// Sauvegarder l’état de la partie
const saveProgress = () => {
  localStorage.setItem('storyProgress', JSON.stringify({
    storyId: route.params.storyId,
    chapterId: currentChapterId.value,
    chargeMentale: chargeMentale.value,
    sommeil: sommeil.value,
    notes: notes.value
  }));
};

// Confirmer le retour à l’accueil
const confirmReturnHome = () => {
  showNotification({
    type: 'warning',
    title: 'Quitter le chapitre',
    message: 'Voulez-vous quitter ? La progression sera sauvegardée.',
    action: true,
    actionText: 'Quitter',
    position: 'top-4 inset-x-0 mx-auto'
  }).then(result => {
    if (result === 'action') {
      saveProgress();
      router.push('/');
    }
  });
};

// Chargement initial
onMounted(async () => {
  const { chapterId } = route.params;
  if (chapterId) currentChapterId.value = parseInt(chapterId);

  try {
    const savedProgress = localStorage.getItem('storyProgress');
    if (savedProgress) {
      const progress = JSON.parse(savedProgress);
      chargeMentale.value = progress.chargeMentale ?? 3;
      sommeil.value = progress.sommeil ?? 7;
      notes.value = progress.notes ?? 6;
      if (progress.chapterId) currentChapterId.value = parseInt(progress.chapterId);
    } else {
      await axios.post('/metrics/reset');
    }

    setMetric('stress_level', chargeMentale.value);
    setMetric('sleep_level', sommeil.value);
    setMetric('grades_level', notes.value);
  } catch {
    showNotification({ type: 'warning', message: 'Erreur de réinitialisation', duration: 3000 });
  }

  fetchChapter(currentChapterId.value);
});

// 🎯 Suivre les changements d’état
watch(currentChapterId, fetchChapter);
watch([chargeMentale, sommeil, notes], () => {
  saveProgress();
  checkWarnings();
});
</script>

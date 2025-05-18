<!--
/**
 * @component StoryList.vue
 * Page d'accueil du jeu interactif "Batterie Mentale".
 * 
 * Permet de :
 * - consulter et lancer des histoires ;
 * - reprendre une partie sauvegardée (métriques locales) ;
 * - accéder aux témoignages (connexion requise).
 *
 * API utilisée :
 * - GET /stories
 * - GET /story/:id
 * - POST /metrics/reset et /metrics/update
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->
<template>
  <!-- Noter que nous avons ajouté dark:bg-gray-800 ici pour le conteneur principal -->
  <main class="min-h-screen py-10 px-4 bg-gray-50 dark:bg-gray-800 transition-colors">

    <!-- Bouton d'accès aux témoignages -->
    <div class="fixed top-5 right-5 z-50 mt-4 mr-4">
      <button
        @click="goToTestimonies"
        class="px-4 py-2 bg-yellow-200 hover:bg-yellow-500 dark:bg-yellow-700 dark:hover:bg-yellow-600 text-black dark:text-white font-semibold rounded-lg shadow-md transition"
      >
        💬 Découvrir des récits d'étudiants
      </button>
    </div>

    <!-- Affichage du chargement -->
    <div v-if="loading" class="fixed inset-0 bg-white/80 dark:bg-gray-900/80 flex flex-col items-center justify-center z-50">
      <div class="w-12 h-12 border-4 border-gray-200 dark:border-gray-600 border-t-green-300 rounded-full animate-spin"></div>
      <div class="mt-4 text-lg text-gray-700 dark:text-gray-300">Chargement des histoires...</div>
    </div>

    <!-- Affichage des erreurs -->
    <div v-else-if="error" class="max-w-lg mx-auto p-6 bg-red-100 dark:bg-red-900 border border-red-300 dark:border-red-700 rounded-lg text-center">
      <div class="text-4xl mb-4">⚠️</div>
      <div class="text-red-700 dark:text-red-200 font-semibold mb-4">{{ error }}</div>
      <button @click="loadStories" class="px-6 py-2 bg-red-500 text-white rounded hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-600">
        Réessayer
      </button>
    </div>

    <!-- Progression sauvegardée -->
    <div v-if="savedProgress" class="mb-10 bg-green-50 dark:bg-green-900/30 p-6 rounded-lg border-l-4 border-green-400 dark:border-green-600">
      <h3 class="text-green-700 dark:text-green-300 font-bold text-xl mb-4 text-center">Continuer votre aventure</h3>
      <div class="space-y-4">
        <div v-for="metric in metrics" :key="metric.name" class="flex items-center gap-4">
          <div class="w-32 text-gray-700 dark:text-gray-300 font-semibold">{{ metric.label }}</div>
          <div class="flex-1 bg-gray-200 dark:bg-gray-600 h-3 rounded overflow-hidden">
            <div :class="metric.color" class="h-3" :style="{ width: `${metric.value * 10}%` }"></div>
          </div>
          <div class="w-10 text-right text-gray-700 dark:text-gray-300">{{ metric.value }}/10</div>
        </div>
      </div>

      <!-- Actions de sauvegarde -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
        <button @click="continueLastStory" class="px-6 py-2 bg-green-500 dark:bg-green-600 text-white rounded hover:bg-green-600 dark:hover:bg-green-700 flex items-center gap-2 justify-center">
          ▶️ Reprendre
        </button>
        <button @click="clearSavedProgress" class="px-6 py-2 bg-gray-400 dark:bg-gray-600 text-white rounded hover:bg-gray-500 dark:hover:bg-gray-700 flex items-center gap-2 justify-center">
          🗑️ Effacer
        </button>
      </div>
    </div>

    <!-- Liste des histoires -->
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-3xl font-handwritten text-indigo-700 dark:text-indigo-300 text-center mb-6">Choisir une nouvelle histoire</h2>
      <div v-if="stories.length === 0" class="text-center text-gray-500 dark:text-gray-400">Aucune histoire disponible.</div>
      <div v-for="story in stories" :key="story.id" class="bg-white dark:bg-gray-700 mb-6 p-6 border dark:border-gray-600 rounded-lg hover:shadow-md transition">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">📘 {{ story.title }}</h3>
        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ story.summary }}</p>
        <button @click="startStory(story.id)" class="w-full bg-indigo-500 dark:bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-600 dark:hover:bg-indigo-700 flex items-center justify-center gap-2">
          ▶️ Commencer
        </button>
      </div>
    </div>

    <!-- Informations sur les mécaniques -->
    <div class="max-w-4xl mx-auto px-4 mt-12 p-8 bg-white dark:bg-gray-700 rounded-xl shadow-md border border-gray-200 dark:border-gray-600">
      <h3 class="text-3xl font-handwritten text-indigo-700 dark:text-indigo-300 text-center mb-6">Comprendre les mécaniques du jeu</h3>
      <ul class="space-y-6">
        <li class="flex items-center gap-4">
          <div class="flex-shrink-0 bg-red-100 dark:bg-red-800 text-red-500 dark:text-red-300 rounded-full p-3 text-2xl shadow-inner">🧠</div>
          <div>
            <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Charge Mentale</p>
            <p class="text-gray-600 dark:text-gray-300 text-sm">Elle représente ton niveau de stress. Si elle atteint 10, c'est le burn-out garanti !</p>
          </div>
        </li>
        <li class="flex items-center gap-4">
          <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-800 text-blue-500 dark:text-blue-300 rounded-full p-3 text-2xl shadow-inner">😴</div>
          <div>
            <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Sommeil</p>
            <p class="text-gray-600 dark:text-gray-300 text-sm">Ton énergie quotidienne. À 0, tu frôles l'épuisement total.</p>
          </div>
        </li>
        <li class="flex items-center gap-4">
          <div class="flex-shrink-0 bg-green-100 dark:bg-green-800 text-green-500 dark:text-green-300 rounded-full p-3 text-2xl shadow-inner">📚</div>
          <div>
            <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Notes</p>
            <p class="text-gray-600 dark:text-gray-300 text-sm">Ta réussite académique. À 0, c'est l'échec scolaire.</p>
          </div>
        </li>
      </ul>
      <p class="text-center italic text-gray-600 dark:text-gray-400 mt-8 text-sm">
        Chaque choix influence ton parcours. Trouve l'équilibre entre performance et bien-être !
      </p>
    </div>

    <!-- Footer -->
    <footer class="text-center text-sm text-gray-500 dark:text-gray-400 mt-12">
      Développé à la HEIG-VD • Projet étudiant 2025
    </footer>

  </main>
</template>

<script>
import axios from 'axios';
import { setMetric } from '@/utils/metrics';
import { showNotification } from '@/stores/notificationStore';

export default {
  data() {
    return {
      stories: [],
      loading: true,
      error: null,
      savedProgress: null,
    };
  },
  computed: {
    metrics() {
      if (!this.savedProgress) return [];
      return [
        { name: 'chargeMentale', label: 'Charge Mentale', value: this.savedProgress.chargeMentale, color: 'bg-red-400 dark:bg-red-500' },
        { name: 'sommeil', label: 'Sommeil', value: this.savedProgress.sommeil, color: 'bg-blue-400 dark:bg-blue-500' },
        { name: 'notes', label: 'Notes', value: this.savedProgress.notes, color: 'bg-green-400 dark:bg-green-500' },
      ];
    },
  },
  mounted() {
    this.loadSavedProgress();
    this.loadStories();
  },
  methods: {
    goToTestimonies() {
      this.$router.push('/login');
    },
    loadSavedProgress() {
      const saved = localStorage.getItem('storyProgress');
      if (saved) {
        try {
          const progress = JSON.parse(saved);
          this.savedProgress = {
            storyId: progress.storyId,
            chapterId: progress.chapterId,
            chargeMentale: progress.chargeMentale ?? 0,
            sommeil: progress.sommeil ?? 10,
            notes: progress.notes ?? 7,
          };
        } catch (e) {
          localStorage.removeItem('storyProgress');
        }
      }
    },
    loadStories() {
      this.loading = true;
      this.error = null;

      axios.get('/stories', { headers: { 'Accept': 'application/json' } })
        .then(res => {
          this.stories = Array.isArray(res.data) ? res.data : res.data.data || [];
          this.stories.forEach(this.loadStoryChapters);
        })
        .catch(err => {
          this.error = err.response?.data?.message || 'Erreur de chargement';
        })
        .finally(() => {
          this.loading = false;
        });
    },
    loadStoryChapters(story) {
      axios.get(`/story/${story.id}`, { headers: { 'Accept': 'application/json' } })
        .then(res => {
          story.chapters = res.data.chapters;
        })
        .catch(console.error);
    },
    continueLastStory() {
      if (!this.savedProgress) return;
      this.loading = true;

      axios.post('/metrics/update', {
        stress_level: this.savedProgress.chargeMentale,
        sleep_level: this.savedProgress.sommeil,
        grades_level: this.savedProgress.notes
      }).then(() => {
        this.$router.push(`/story/${this.savedProgress.storyId}`);
      }).catch(() => {
        this.$router.push(`/story/${this.savedProgress.storyId}/chapter/${this.savedProgress.chapterId}`);
      }).finally(() => {
        this.loading = false;
      });
    },
    clearSavedProgress() {
      // Remplacer l'alerte native par une notification stylisée
      showNotification({
        type: 'warning',
        title: 'Supprimer la progression',
        message: 'Êtes-vous sûr de vouloir effacer votre progression sauvegardée ?',
        action: true,
        actionText: 'Supprimer',
        position: 'top-4 inset-x-0 mx-auto',
        duration: 0 // La notification reste jusqu'à ce que l'utilisateur interagisse
      }).then(result => {
        if (result === 'action') {
          localStorage.removeItem('storyProgress');
          this.savedProgress = null;
          
          // Afficher une notification de confirmation après la suppression
          showNotification({
            type: 'success',
            message: 'Votre progression a été effacée avec succès.',
            duration: 3000
          });
        }
        }); 
},  
    async startStory(storyId) {
      try {
        this.loading = true;
        await axios.post('/metrics/reset');
        localStorage.removeItem('storyProgress');
        const story = this.stories.find(s => s.id === storyId);
        const firstChapter = story?.chapters?.find(ch => ch.chapter_number === 1);
        this.$router.push(`/story/${storyId}`);
      } catch (err) {
        this.error = err.response?.data?.message || 'Erreur au lancement';
        this.loading = false;
      }
    }
  }
};
</script>
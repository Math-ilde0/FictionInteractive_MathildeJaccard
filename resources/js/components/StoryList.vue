<template>
  <main class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-indigo-50 py-10 px-4">

<!-- Bouton Témoignages (jaune chaleureux) -->
<div class="fixed top-5 right-5 z-50 mt-4 mr-4">
  <button 
    @click="goToTestimonies" 
    class="px-4 py-2 bg-yellow-200 hover:bg-yellow-500 text-black font-semibold rounded-lg shadow-md transition"
  >
    💬 Découvrir des récits d'étudiants
  </button>
</div>



    <!-- Loading -->
    <div v-if="loading" class="fixed inset-0 bg-white/80 flex flex-col items-center justify-center z-50">
      <div class="w-12 h-12 border-4 border-gray-200 border-t-green-300 rounded-full animate-spin"></div>
      <div class="mt-4 text-lg text-gray-700">Chargement des histoires...</div>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="max-w-lg mx-auto p-6 bg-red-100 border border-red-300 rounded-lg text-center">
      <div class="text-4xl mb-4">⚠️</div>
      <div class="text-red-700 font-semibold mb-4">{{ error }}</div>
      <button @click="loadStories" class="px-6 py-2 bg-red-500 text-white rounded hover:bg-red-600">
        Réessayer
      </button>
    </div>

    <!-- Saved Progress -->
    <div v-if="savedProgress" class="mb-10 bg-green-50 p-6 rounded-lg border-l-4 border-green-400">
      <h3 class="text-green-700 font-bold text-xl mb-4 text-center">Continuer votre aventure</h3>

      <div class="space-y-4">
        <div v-for="metric in metrics" :key="metric.name" class="flex items-center gap-4">
          <div class="w-32 text-gray-700 font-semibold">{{ metric.label }}</div>
          <div class="flex-1 bg-gray-200 h-3 rounded overflow-hidden">
            <div :class="metric.color" class="h-3" :style="{ width: `${metric.value * 10}%` }"></div>
          </div>
          <div class="w-10 text-right text-gray-700">{{ metric.value }}/10</div>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
        <button @click="continueLastStory" class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 flex items-center gap-2 justify-center">
          ▶️ Reprendre
        </button>
        <button @click="clearSavedProgress" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 flex items-center gap-2 justify-center">
          🗑️ Effacer
        </button>
      </div>
    </div>

    <!-- List of Stories -->
    <div>
      <h2 class="text-3xl font-handwritten text-indigo-700 text-center mb-6">Choisir une nouvelle histoire</h2>

      <div v-if="stories.length === 0" class="text-center text-gray-500">Aucune histoire disponible.</div>

      <div v-for="story in stories" :key="story.id" class="mb-6 p-6 border rounded-lg hover:shadow-md transition">
        <h3 class="text-xl font-bold text-gray-800 mb-2">   📘 {{ story.title }}</h3>
        <p class="text-gray-600 mb-4">{{ story.summary }}</p>
        <button @click="startStory(story.id)" class="w-full bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 flex items-center justify-center gap-2">
          ▶️ Commencer
        </button>
      </div>
    </div>

    <!-- Info Section -->
    <div class="mt-10 p-6 bg-gray-100 rounded-lg">
      <h3 class="text-2xl font-bold text-center mb-4">À propos du jeu</h3>
      <ul class="space-y-6">
        <li class="flex items-start gap-4">
          <span class="bg-red-100 text-red-500 rounded-full p-2 text-xl">🧠</span>
          <div>
            <strong class="text-gray-700">Charge Mentale</strong>
            <p class="text-gray-600">Votre stress. À 10, c'est le burn-out.</p>
          </div>
        </li>
        <li class="flex items-start gap-4">
          <span class="bg-blue-100 text-blue-500 rounded-full p-2 text-xl">😴</span>
          <div>
            <strong class="text-gray-700">Sommeil</strong>
            <p class="text-gray-600">Votre énergie. À 0, c'est l'épuisement.</p>
          </div>
        </li>
        <li class="flex items-start gap-4">
          <span class="bg-green-100 text-green-500 rounded-full p-2 text-xl">📚</span>
          <div>
            <strong class="text-gray-700">Notes</strong>
            <p class="text-gray-600">Votre réussite académique. À 0, c'est l'échec.</p>
          </div>
        </li>
      </ul>
      <p class="text-center italic text-gray-600 mt-6">
        Chaque décision impacte votre progression. Trouvez le bon équilibre !
      </p>
    </div>
    <footer class="text-center text-sm text-gray-500 mt-12">
  Développé à la HEIG-VD • Projet étudiant 2025
</footer>

  </main>
</template>

<script>
import axios from 'axios';
import { setMetric, getMetric } from '/resources/js/utils/metrics.js';

export default {
  data() {
    return {
      stories: [],
      loading: true,
      error: null,
      savedProgress: null
    };
  },
  computed: {
    metrics() {
      if (!this.savedProgress) return [];

      return [
        { name: 'chargeMentale', label: 'Charge Mentale', value: this.savedProgress.chargeMentale, color: 'bg-red-400' },
        { name: 'sommeil', label: 'Sommeil', value: this.savedProgress.sommeil, color: 'bg-blue-400' },
        { name: 'notes', label: 'Notes', value: this.savedProgress.notes, color: 'bg-green-400' }
      ];
    }
  },
  mounted() {
    // Charger la progression sauvegardée
    this.loadSavedProgress();
    
    // Charger les histoires disponibles
    this.loadStories();
  },
  methods: {
    // Méthode pour rediriger vers la page des témoignages
    goToTestimonies() {
      // Utilisation de location.href pour éviter les problèmes de routage Vue
      window.location.href = '/testimonies';
    },
    
    // Charger les histoires disponibles
    loadStories() {
      this.loading = true;
      this.error = null;
      
      axios.get('/stories', {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      })
        .then(response => {
          
          // Vérifiez le type de données reçu
          if (typeof response.data === 'string' && response.data.includes('<!DOCTYPE html>')) {
            console.error('Reçu du HTML au lieu du JSON');
            this.error = 'Format de données incorrect reçu du serveur';
            this.stories = [];
          } else if (Array.isArray(response.data)) {
            this.stories = response.data;
          } else if (response.data && Array.isArray(response.data.data)) {
            this.stories = response.data.data;
          } else {
            this.stories = [];
            console.error('Format de données inattendu:', response.data);
          }
          
          this.loading = false;
        })
        .catch(error => {
          console.error('Error loading stories:', error);
          this.error = error.response?.data?.message || 'Erreur lors du chargement des histoires';
          this.loading = false;
        });
    },
    
    // Charger la progression sauvegardée depuis localStorage
    loadSavedProgress() {
      const savedProgressData = localStorage.getItem('storyProgress');
      if (savedProgressData) {
        try {
          const progress = JSON.parse(savedProgressData);
          
          // Valider que toutes les métriques sont présentes ou les initialiser
          this.savedProgress = {
            storyId: progress.storyId,
            chapterId: progress.chapterId,
            chargeMentale: progress.chargeMentale !== undefined ? progress.chargeMentale : 0,
            sommeil: progress.sommeil !== undefined ? progress.sommeil : 10,
            notes: progress.notes !== undefined ? progress.notes : 7
          };
        } catch (e) {
          console.error('Erreur lors du chargement de la progression:', e);
          localStorage.removeItem('storyProgress');
        }
      }
    },
    
    // Continuer la dernière histoire sauvegardée
    continueLastStory() {
      if (this.savedProgress) {
        this.loading = true;

        axios.post('/metrics/update', {
          stress_level: this.savedProgress.chargeMentale,
          sleep_level: this.savedProgress.sommeil,
          grades_level: this.savedProgress.notes
        })
          .then(() => {
            this.$router.push(`/story/${this.savedProgress.storyId}/chapter/${this.savedProgress.chapterId}`);
          })
          .catch(error => {
            console.error('Erreur lors de la reprise de la partie:', error);
            this.$router.push(`/story/${this.savedProgress.storyId}/chapter/${this.savedProgress.chapterId}`);
          })
          .finally(() => {
            this.loading = false;
          });
      }
    },
    
    // Effacer la progression sauvegardée
    clearSavedProgress() {
      if (confirm('Êtes-vous sûr de vouloir effacer votre progression ? Cette action est irréversible.')) {
        localStorage.removeItem('storyProgress');
        this.savedProgress = null;
      }
    },
    
    // Démarrer une nouvelle histoire
    async startStory(storyId) {
      try {
        this.loading = true;
        
        // Réinitialiser le niveau de stress avant de commencer une nouvelle histoire
        await axios.post('/metrics/reset');
        
        // Effacer la progression précédente
        localStorage.removeItem('storyProgress');
        
        // Naviguer vers le premier chapitre de l'histoire sélectionnée
        this.$router.push(`/story/${storyId}/chapter/1`);
      } catch (error) {
        console.error('Error starting story:', error);
        this.error = error.response?.data?.message || 'Erreur lors du démarrage de l\'histoire';
        this.loading = false;
      }
    }
  }
};
</script>
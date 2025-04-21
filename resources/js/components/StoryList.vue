<template>
  <main>
    <div v-if="loading" class="loading-overlay">
      <div class="loading-spinner"></div>
      <div class="loading-text">Chargement des histoires...</div>
    </div>

    <div v-else-if="error" class="error-container">
      <div class="error-icon">⚠️</div>
      <div class="error-message">{{ error }}</div>
      <button @click="loadStories" class="retry-button">Réessayer</button>
    </div>

    <div v-else class="book-page">
     
      
      <!-- Section pour continuer la progression sauvegardée -->
      
      
      <!-- Show error message if no stories are found -->
      <p v-if="stories.length === 0 && !loading">Aucune histoire disponible.</p>

      <!-- List of stories -->
      <div v-else class="stories-list">
        <div 
          v-for="story in stories" 
          :key="story.id" 
          class="story-item"
        >
          <h2>{{ story.title }}</h2>
          <p>{{ story.summary }}</p>
          <button @click="startStory(story.id)" class="start-button">
            <i class="fas fa-book-open"></i> Commencer cette histoire
          </button>
        
        </div>
        <div v-if="savedProgress" class="continue-story">
        <h3>Continuer votre aventure</h3>
        <p>Niveau de stress actuel: {{ savedProgress.stressLevel }}/10</p>
        <button @click="continueLastStory" class="continue-button">
          <i class="fas fa-play-circle"></i> Reprendre où vous avez arrêté
        </button>
        <button @click="clearSavedProgress" class="clear-button">
          <i class="fas fa-trash"></i> Effacer la sauvegarde
        </button>
      </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      stories: [],        // Holds the list of stories
      loading: true,      // Tracks loading state
      error: null,        // Stores error messages
      savedProgress: null // Stores saved game progress
    };
  },
  mounted() {
    // Charger la progression sauvegardée
    this.loadSavedProgress();
    
    // Charger les histoires disponibles
    this.loadStories();
  },
  methods: {
    // Charger les histoires disponibles
    loadStories() {
      this.loading = true;
      this.error = null;
      
      axios.get('/api/stories')
        .then(response => {
          this.stories = response.data;
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
          this.savedProgress = JSON.parse(savedProgressData);
        } catch (e) {
          console.error('Erreur lors du chargement de la progression:', e);
          localStorage.removeItem('storyProgress');
        }
      }
    },
    
    // Continuer la dernière histoire sauvegardée
    continueLastStory() {
      if (this.savedProgress) {
        // Mettre à jour le niveau de stress côté serveur
        axios.post('/api/stress/update', { stress_level: this.savedProgress.stressLevel })
          .then(() => {
            // Naviguer vers le chapitre sauvegardé
            this.$router.push(`/story/${this.savedProgress.storyId}/chapter/${this.savedProgress.chapterId}`);
          })
          .catch(error => {
            console.error('Erreur lors de la reprise de la partie:', error);
            // Naviguer quand même en cas d'erreur
            this.$router.push(`/story/${this.savedProgress.storyId}/chapter/${this.savedProgress.chapterId}`);
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
        await axios.post('/api/stress/reset');
        
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
  background-color: white;
  max-width: 700px;
  margin: 0 auto;
  padding: 60px 40px;
  border-radius: 8px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.continue-story {
  background-color: #e8f5e9;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 30px;
  text-align: center;
  border-left: 4px solid #66bb6a;
}

.continue-story h3 {
  margin-top: 0;
  color: #2e7d32;
}

.continue-button {
  background-color: #66bb6a;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
  font-size: 1rem;
  margin-right: 10px;
}

.continue-button:hover {
  background-color: #4caf50;
}

.clear-button {
  background-color: #bdbdbd;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
  font-size: 1rem;
}

.clear-button:hover {
  background-color: #9e9e9e;
}

.stories-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-top: 30px;
}

.story-item {
  border: 1px solid #e0e0e0;
  padding: 20px;
  border-radius: 8px;
  transition: transform 0.3s, box-shadow 0.3s;
}

.story-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.story-item h2 {
  margin-top: 0;
  color: #333;
}

.story-item p {
  color: #666;
  margin-bottom: 15px;
}

.start-button {
  display: block;
  width: 100%;
  padding: 12px 20px;
  font-size: 1.1rem;
  background-color: #a5d6a7;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.start-button:hover {
  background-color: #81c784;
}

/* Styles responsifs */
@media (max-width: 768px) {
  .book-page {
    padding: 30px 20px;
    max-width: 90%;
  }
  
  .continue-story {
    padding: 15px;
  }
  
  .continue-button, .clear-button {
    display: block;
    width: 100%;
    margin: 10px 0;
  }
}
</style>
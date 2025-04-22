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
      <h1>Batterie Mentale</h1>
      <p class="intro-text">
        Cette histoire interactive vous place dans la peau d'un étudiant en ingénierie des médias à la HEIG-VD.
        Naviguez entre projets, cours et vie personnelle en faisant des choix qui influenceront votre charge mentale,
        votre niveau de sommeil et vos résultats académiques.
      </p>
      
      <!-- Section pour continuer la progression sauvegardée -->
      <div v-if="savedProgress" class="continue-story">
        <h3>Continuer votre aventure</h3>
        <div class="metrics-preview">
          <div class="metric-preview">
            <div class="metric-title">Charge Mentale</div>
            <div class="metric-bar">
              <div class="metric-fill charge-mental" :style="{ width: `${savedProgress.chargeMentale * 10}%` }"></div>
            </div>
            <div class="metric-value">{{ savedProgress.chargeMentale }}/10</div>
          </div>
          
          <div class="metric-preview">
            <div class="metric-title">Sommeil</div>
            <div class="metric-bar">
              <div class="metric-fill sleep" :style="{ width: `${savedProgress.sommeil * 10}%` }"></div>
            </div>
            <div class="metric-value">{{ savedProgress.sommeil }}/10</div>
          </div>
          
          <div class="metric-preview">
            <div class="metric-title">Notes</div>
            <div class="metric-bar">
              <div class="metric-fill grades" :style="{ width: `${savedProgress.notes * 10}%` }"></div>
            </div>
            <div class="metric-value">{{ savedProgress.notes }}/10</div>
          </div>
        </div>
        
        <div class="continue-buttons">
          <button @click="continueLastStory" class="continue-button">
            <i class="fas fa-play-circle"></i> Reprendre où vous avez arrêté
          </button>
          <button @click="clearSavedProgress" class="clear-button">
            <i class="fas fa-trash"></i> Effacer la sauvegarde
          </button>
        </div>
      </div>
      
      <!-- Liste des histoires -->
      <div class="stories-list">
        <h2>Choisir une nouvelle histoire</h2>
        <p v-if="stories.length === 0 && !loading">Aucune histoire disponible.</p>

        <div 
          v-for="story in stories" 
          :key="story.id" 
          class="story-item"
        >
          <h3>{{ story.title }}</h3>
          <p class="story-summary">{{ story.summary }}</p>
          <button @click="startStory(story.id)" class="start-button">
            <i class="fas fa-book-open"></i> Commencer cette histoire
          </button>
        </div>
      </div>
      
      <!-- Section d'aide et d'explication -->
      <div class="info-section">
        <h3>À propos du jeu</h3>
        <p>
          Dans cette aventure interactive, vous devrez gérer trois aspects de votre vie étudiante :
        </p>
        <ul class="info-list">
          <li>
            <span class="info-icon charge">🧠</span>
            <div>
              <strong>Charge Mentale</strong>
              <p>Représente votre niveau de stress et d'anxiété. Si elle atteint 10, vous risquez un burn-out.</p>
            </div>
          </li>
          <li>
            <span class="info-icon sleep">😴</span>
            <div>
              <strong>Sommeil</strong>
              <p>Représente votre niveau de repos. S'il tombe à 0, vous vous effondrerez d'épuisement.</p>
            </div>
          </li>
          <li>
            <span class="info-icon grades">📚</span>
            <div>
              <strong>Notes</strong>
              <p>Représente votre réussite académique. Si elles tombent à 0, vous risquez d'échouer votre semestre.</p>
            </div>
          </li>
        </ul>
        <p class="info-footer">
          Chaque choix que vous ferez aura un impact sur ces trois aspects. Trouvez le bon équilibre !
        </p>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';
import { setCookie, getCookie } from '@/utils/cookies';

export default {
  data() {
    return {
      stories: [],
      loading: true,
      error: null,
      savedProgress: null
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
  
  axios.get('/stories')
    .then(response => {
      console.log('Response from /stories:', response);
      
      // S'assurer que nous avons un tableau valide
      if (Array.isArray(response.data)) {
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
    
    // Mettre à jour les métriques côté serveur
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
},

  }
};
</script>

<style scoped>
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
  max-width: 800px;
  margin: 0 auto;
  padding: 40px;
  border-radius: 8px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 2.5rem;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

.intro-text {
  font-size: 1.1rem;
  line-height: 1.6;
  color: #555;
  text-align: center;
  margin-bottom: 30px;
  font-style: italic;
}

/* Styles pour la section de reprise */
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

.metrics-preview {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin: 15px 0;
}

.metric-preview {
  display: flex;
  align-items: center;
  gap: 10px;
}

.metric-title {
  width: 120px;
  font-weight: bold;
  font-size: 0.9rem;
  text-align: left;
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

.continue-buttons {
  display: flex;
  flex-direction: row;
  justify-content: center;
  gap: 10px;
  margin-top: 15px;
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

/* Styles pour la liste d'histoires */
.stories-list {
  margin-top: 40px;
}

.stories-list h2 {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.story-item {
  border: 1px solid #e0e0e0;
  padding: 20px;
  border-radius: 8px;
  transition: transform 0.3s, box-shadow 0.3s;
  margin-bottom: 20px;
}

.story-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.story-item h3 {
  margin-top: 0;
  color: #333;
  font-size: 1.5rem;
}

.story-summary {
  color: #666;
  margin-bottom: 15px;
  line-height: 1.5;
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

/* Section d'information */
.info-section {
  margin-top: 40px;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
}

.info-section h3 {
  text-align: center;
  color: #333;
  margin-top: 0;
  margin-bottom: 15px;
}

.info-list {
  list-style: none;
  padding: 0;
}

.info-list li {
  display: flex;
  margin-bottom: 15px;
  align-items: flex-start;
}

.info-icon {
  font-size: 1.5rem;
  margin-right: 15px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

.info-icon.charge {
  background-color: rgba(239, 83, 80, 0.1);
  color: #ef5350;
}

.info-icon.sleep {
  background-color: rgba(66, 165, 245, 0.1);
  color: #42a5f5;
}

.info-icon.grades {
  background-color: rgba(102, 187, 106, 0.1);
  color: #66bb6a;
}

.info-list li div {
  flex: 1;
}

.info-list li div strong {
  display: block;
  margin-bottom: 5px;
  color: #333;
}

.info-list li div p {
  margin: 0;
  color: #666;
  font-size: 0.95rem;
}

.info-footer {
  text-align: center;
  font-style: italic;
  margin-top: 20px;
  color: #555;
}

/* Styles responsifs */
@media (max-width: 768px) {
  .book-page {
    padding: 20px;
    max-width: 90%;
  }
  
  h1 {
    font-size: 2rem;
  }
  
  .continue-story {
    padding: 15px;
  }
  
  .continue-buttons {
    flex-direction: column;
  }
  
  .continue-button, .clear-button {
    width: 100%;
  }
  
  .info-list li {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  
  .info-icon {
    margin-right: 0;
    margin-bottom: 10px;
  }
}
</style>
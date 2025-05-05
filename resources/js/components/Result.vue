<template>
  <main class="min-h-screen py-10 px-4 bg-gray-50">
    <!-- Résultat en fonction de l'outcome -->
    <div v-if="outcome" class="max-w-4xl mx-auto p-8 rounded-lg shadow-md bg-white">
      <div :class="resultClasses">
        <h2 class="text-3xl font-bold text-center mb-6">{{ title }}</h2>
        <p class="text-gray-700 text-center mb-6">{{ message }}</p>

        <template v-if="outcome === 'success'">
          <div class="bg-green-100 text-green-800 rounded-lg p-4 text-center font-semibold mb-6">
            🌟 Déverrouillé : Maître de la Sérénité
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Techniques à retenir</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Planification et organisation des tâches</li>
              <li>Priorisation des activités importantes</li>
              <li>Pauses régulières pour maintenir l'équilibre</li>
              <li>Communication de vos limites</li>
              <li>Soin de votre santé physique et mentale</li>
            </ul>
          </div>
        </template>

        <template v-else-if="outcome === 'warning'">
          <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4 text-center font-semibold mb-6">
            ⚠️ Vous avez évité le pire !
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Conseils pour la suite</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Identifiez les signes avant-coureurs du stress</li>
              <li>Établissez des limites plus claires</li>
              <li>Pratiquez la pleine conscience quotidiennement</li>
              <li>Consultez un professionnel si nécessaire</li>
              <li>Prévoyez des périodes de récupération</li>
            </ul>
          </div>
        </template>

        <template v-else-if="outcome === 'failure'">
          <div class="bg-red-100 text-red-800 rounded-lg p-4 text-center font-semibold mb-6">
            🔥 Burn-out détecté
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
            <div>
              <h3 class="text-lg font-semibold mb-2">📚 Trouver de l'aide</h3>
              <ul class="list-disc list-inside text-gray-600 space-y-2">
                <li><a href="https://www.147.ch" target="_blank" class="text-blue-600 hover:underline">147.ch</a> – Ligne gratuite 24h/24 pour les jeunes.</li>
                <li><a href="https://www.ontecoute.ch" target="_blank" class="text-blue-600 hover:underline">Ontecoute.ch</a> – Aide psychologique anonyme.</li>
              </ul>
            </div>
            <div>
              <h4 class="font-semibold">🏥 Associations de soutien</h4>
              <ul class="list-disc list-inside text-gray-600 space-y-2">
                <li><a href="https://www.santepsy.ch" target="_blank" class="text-blue-600 hover:underline">SantéPsy.ch</a></li>
                <li><a href="https://www.noburnout.ch" target="_blank" class="text-blue-600 hover:underline">NoBurnout.ch</a></li>
              </ul>
            </div>
          </div>
        </template>

        <template v-else-if="outcome === 'sleep-crisis'">
          <div class="bg-blue-100 text-blue-800 rounded-lg p-4 text-center font-semibold mb-6">
            😴 Épuisement physique
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="italic mb-6 text-gray-600">
              Vous vous êtes endormi(e) en cours à cause du manque de sommeil...
            </p>
            <h3 class="text-xl font-semibold mb-4">Pourquoi le sommeil est vital :</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Consolidation de la mémoire</li>
              <li>Capacité de concentration</li>
              <li>Renforcement du système immunitaire</li>
              <li>Gestion du stress</li>
            </ul>
          </div>
        </template>

        <template v-else-if="outcome === 'academic-crisis'">
          <div class="bg-purple-100 text-purple-800 rounded-lg p-4 text-center font-semibold mb-6">
            📉 Échec académique
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Comment rebondir :</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Analyser les causes de l'échec</li>
              <li>Demander conseil à l'orientation</li>
              <li>Redéfinir ses objectifs personnels</li>
              <li>Améliorer ses méthodes d'apprentissage</li>
              <li>Garder confiance en soi</li>
            </ul>
          </div>
        </template>

        <template v-else>
          <div class="text-center text-gray-500">
            ⚠️ Une erreur est survenue.
          </div>
        </template>
      </div>

      <!-- Boutons -->
      <div class="flex justify-center gap-4 mt-10">
        <router-link to="/" class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-center">
          Retour à l'accueil
        </router-link>
        <button @click="restartGame" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
          Réessayer
        </button>
      </div>
    </div>
  </main>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

// Récupère le type de résultat depuis les paramètres de route
const outcome = computed(() => route.params.outcome);

// Fonction pour recommencer le jeu
const restartGame = async () => {
  try {
    // Réinitialiser toutes les métriques
    await axios.post('/api/metrics/reset');
    
    // Effacer la progression sauvegardée
    localStorage.removeItem('storyProgress');
    
    // Retourner à la liste des histoires
    router.push('/');
  } catch (error) {
    console.error('Erreur lors du redémarrage:', error);
    // En cas d'échec, rediriger quand même vers l'accueil
    router.push('/');
  }
};
</script>

<style scoped>
.result {
  max-width: 800px;
  margin: 0 auto;
  padding: 30px;
  border-radius: 10px;
  color: #333;
  margin-bottom: 20px;
}

.result h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  text-align: center;
}

.result p {
  font-size: 1.2rem;
  line-height: 1.6;
  margin-bottom: 20px;
}

.result-success {
  background-color: #e8f5e9;
  border-left: 5px solid #66bb6a;
}

.result-warning {
  background-color: #fff8e1;
  border-left: 5px solid #ffd54f;
}

.result-failure {
  background-color: #ffebee;
  border-left: 5px solid #ef5350;
}

.result-sleep {
  background-color: #e3f2fd;
  border-left: 5px solid #42a5f5;
}

.result-academic {
  background-color: #ede7f6;
  border-left: 5px solid #7e57c2;
}

.result-error {
  background-color: #f5f5f5;
  border-left: 5px solid #9e9e9e;
}

.achievement {
  background-color: rgba(0, 0, 0, 0.05);
  padding: 10px 15px;
  border-radius: 5px;
  text-align: center;
  margin: 20px 0;
  font-weight: bold;
}

.scenario-description {
  font-style: italic;
  background-color: rgba(0, 0, 0, 0.05);
  padding: 15px;
  border-radius: 5px;
  margin: 20px 0;
}

.advice-box {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

.advice-box h3 {
  margin-top: 0;
  color: #555;
  font-size: 1.3rem;
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
  margin-bottom: 15px;
}

.advice-box ul {
  padding-left: 20px;
}

.advice-box li {
  margin-bottom: 10px;
  list-style-type: none;
  position: relative;
  padding-left: 20px;
}

.advice-box li:before {
  content: "→";
  position: absolute;
  left: 0;
  color: #555;
}

.emergency-resources {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

.emergency-resources h3 {
  color: #d32f2f;
  margin-top: 0;
}

.emergency-resources h4 {
  margin-top: 20px;
  margin-bottom: 10px;
  color: #555;
}

.emergency-resources ul {
  padding-left: 20px;
}

.emergency-resources li {
  margin-bottom: 8px;
}

.emergency-resources a {
  color: #1976d2;
  text-decoration: none;
}

.emergency-resources a:hover {
  text-decoration: underline;
}

.result-actions {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 30px;
}

.button {
  padding: 12px 25px;
  border: none;
  border-radius: 5px;
  font-size: 1.1rem;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.3s;
}

.primary {
  background-color: #66bb6a;
  color: white;
}

.primary:hover {
  background-color: #4caf50;
}

.secondary {
  background-color: #bdbdbd;
  color: white;
}

.secondary:hover {
  background-color: #9e9e9e;
}

@media (max-width: 768px) {
  .result {
    padding: 20px;
  }
  
  .result h2 {
    font-size: 1.8rem;
  }
  
  .result-actions {
    flex-direction: column;
    gap: 10px;
  }
  
  .button {
    width: 100%;
    text-align: center;
  }
}
</style>
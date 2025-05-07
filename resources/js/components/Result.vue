<template>
  <main class="min-h-screen py-10 px-4 bg-gray-50">
    <div v-if="outcome" class="max-w-4xl mx-auto p-8 rounded-lg shadow-md bg-white">
      <div :class="resultClasses">
        <h2 class="text-3xl font-bold text-center mb-4">{{ title }}</h2>
        <p class="text-gray-500 italic text-center mb-6">{{ introText }}</p>
        <p class="text-gray-700 text-center mb-6">{{ message }}</p>

        <!-- Succès -->
        <template v-if="outcome === 'success'">
          <div class="bg-green-100 text-green-800 rounded-lg p-4 text-center font-semibold mb-6">
            🌟 Tu franchis la ligne d'arrivée, équilibré et fier.
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">🌱 Ce que tu as appris en chemin :</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Planifier sans tout contrôler</li>
              <li>Dire non quand c’est nécessaire</li>
              <li>Prioriser l’essentiel sans culpabilité</li>
              <li>Demander de l’aide au bon moment</li>
              <li>Respecter ton corps et ton esprit</li>
            </ul>
          </div>
        </template>

        <!-- Avertissement -->
        <template v-else-if="outcome === 'warning'">
          <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4 text-center font-semibold mb-6">
            ⚠️ Tu termines sur les genoux, mais debout.
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">⚠️ Avant la prochaine fois, retiens cela :</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Repérer les signes d’alerte du stress</li>
              <li>Faire des pauses plus tôt, pas quand il est trop tard</li>
              <li>Ne pas confondre performance et épuisement</li>
              <li>Mettre des limites même quand c’est difficile</li>
            </ul>
          </div>
        </template>

        <!-- Échec épuisement -->
        <template v-else-if="outcome === 'failure'">
          <div class="bg-red-100 text-red-800 rounded-lg p-4 text-center font-semibold mb-6">
            🔥 Tu te réveilles sur le canapé d’un ami, vidé, incapable de retourner en cours.
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
            <p class="text-gray-600 italic">
              Cette fois, ton corps a tiré la sonnette d’alarme avant toi. Les semaines sans repos ont eu raison de ton énergie.
            </p>
            <h3 class="text-lg font-semibold mb-4 text-gray-700">🔥 Il est temps de t’entourer :</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-2">
              <li><a href="https://www.147.ch" target="_blank" class="text-blue-600 hover:underline">147.ch</a> – Ligne gratuite 24h/24</li>
              <li><a href="https://www.ontecoute.ch" target="_blank" class="text-blue-600 hover:underline">Ontecoute.ch</a> – Soutien anonyme</li>
            </ul>
            <h4 class="font-semibold">🏥 Associations utiles</h4>
            <ul class="list-disc list-inside text-gray-600 space-y-2">
              <li><a href="https://www.santepsy.ch" target="_blank" class="text-blue-600 hover:underline">SantéPsy.ch</a></li>
              <li><a href="https://www.noburnout.ch" target="_blank" class="text-blue-600 hover:underline">NoBurnout.ch</a></li>
            </ul>
          </div>
        </template>

        <!-- Crise de sommeil -->
        <template v-else-if="outcome === 'sleep-crisis'">
          <div class="bg-blue-100 text-blue-800 rounded-lg p-4 text-center font-semibold mb-6">
            😴 Tu t’es endormi sur le clavier, les pages de code restées incomplètes.
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-600 italic mb-4">
              Ton esprit et ton corps ont choisi le sommeil pour toi. Le professeur t’a doucement réveillé à la fin du cours.
            </p>
            <h3 class="text-lg font-semibold mb-4 text-gray-700">😴 Pourquoi le sommeil n’est jamais du temps perdu :</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Consolider les apprentissages de la journée</li>
              <li>Garder une mémoire vive</li>
              <li>Réguler tes émotions</li>
              <li>Préparer ton cerveau à résoudre des problèmes</li>
            </ul>
          </div>
        </template>

        <!-- Échec académique -->
        <template v-else-if="outcome === 'academic-crisis'">
          <div class="bg-purple-100 text-purple-800 rounded-lg p-4 text-center font-semibold mb-6">
            📉 Les résultats sont tombés, et ils piquent.
          </div>
          <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-600 italic mb-4">
              Les notes ne reflètent pas toujours tout le chemin parcouru. Mais elles t’indiquent qu’un ajustement est nécessaire.
            </p>
            <h3 class="text-lg font-semibold mb-4 text-gray-700">📉 Comment rebondir plus fort :</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
              <li>Analyser ce qui n’a pas fonctionné</li>
              <li>Demander des feedbacks aux professeurs</li>
              <li>Améliorer tes méthodes, pas juste le temps passé</li>
              <li>Revoir tes objectifs personnels</li>
              <li>Ne pas laisser les notes définir ta valeur</li>
            </ul>
          </div>
        </template>

        <!-- Erreur inconnue -->
        <template v-else>
          <div class="text-center text-gray-500">
            ⚠️ Une erreur est survenue.
          </div>
        </template>
      </div>

      <!-- Boutons -->
      <div class="flex justify-center gap-4 mt-10">
        <router-link :to="'/'" class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-center">
          {{ buttonText }}
        </router-link>
        <button @click="restartGame" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
          Rejouer
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

// Classes CSS selon le type de résultat
const resultClasses = computed(() => {
  const type = outcome.value;
  if (type === 'success') return 'result-success';
  if (type === 'warning') return 'result-warning';
  if (type === 'failure') return 'result-failure';
  if (type === 'sleep-crisis') return 'result-sleep';
  if (type === 'academic-crisis') return 'result-academic';
  return 'result-error';
});

// Titres selon le résultat
const title = computed(() => {
  const type = outcome.value;
  if (type === 'success') return 'Félicitations !';
  if (type === 'warning') return 'Mission accomplie... mais à quel prix ?';
  if (type === 'failure') return 'Burn-out !';
  if (type === 'sleep-crisis') return 'Épuisement total !';
  if (type === 'academic-crisis') return 'Échec académique !';
  return 'Fin de partie';
});

// Sous-titre introductif
const introText = computed(() => {
  const type = outcome.value;
  if (type === 'success') return 'Tu as réussi à maintenir un équilibre sain.';
  if (type === 'warning') return 'Tu as atteint tes objectifs, mais ta santé mentale en a souffert.';
  if (type === 'failure') return 'Tu as poussé ton esprit au-delà de ses limites.';
  if (type === 'sleep-crisis') return 'Le manque de sommeil t\'a rattrapé.';
  if (type === 'academic-crisis') return 'Tes notes ont trop chuté.';
  return 'Le jeu est terminé.';
});

// Message principal
const message = computed(() => {
  const type = outcome.value;
  if (type === 'success') return 'Tu as trouvé le juste équilibre entre tes études et ton bien-être.';
  if (type === 'warning') return 'Attention à ne pas reproduire ces schémas à l\'avenir.';
  if (type === 'failure') return 'Il est temps de prendre soin de toi et de demander de l\'aide.';
  if (type === 'sleep-crisis') return 'Le sommeil est essentiel pour ton corps et ton esprit.';
  if (type === 'academic-crisis') return 'Apprendre de ses erreurs est aussi important que réussir.';
  return 'Merci d\'avoir joué !';
});

// Texte du bouton de retour
const buttonText = computed(() => {
  return 'Retourner à l\'accueil';
});

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
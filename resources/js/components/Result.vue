<template>
  <main>
    <!-- Résultat de succès -->
    <div v-if="outcome === 'success'" class="result result-success">
      <h2>🏆 Félicitations !</h2>
      <p>Vous avez brillamment géré votre charge mentale et maintenu votre équilibre pour réussir votre semestre !</p>
      <div class="achievement">
        <span>🌟 Déverrouillé : Maître de la Sérénité</span>
      </div>
      <div class="advice-box">
        <h3>Techniques à retenir</h3>
        <ul>
          <li>Planification et organisation des tâches</li>
          <li>Priorisation des activités importantes</li>
          <li>Pauses régulières pour maintenir l'équilibre</li>
          <li>Communication de vos limites</li>
          <li>Soin de votre santé physique et mentale</li>
        </ul>
      </div>
    </div>

    <!-- Résultat intermédiaire (proche du burn-out) -->
    <div v-else-if="outcome === 'warning'" class="result result-warning">
      <h2>⚠️ Vous avez évité le pire !</h2>
      <p>Vous avez frôlé l'épuisement. Bien que vous ayez terminé votre semestre, votre santé mentale en a souffert.</p>
      <div class="advice-box">
        <h3>Conseils pour la suite</h3>
        <ul>
          <li>Identifiez les signes avant-coureurs du stress</li>
          <li>Établissez des limites plus claires</li>
          <li>Pratiquez la pleine conscience quotidiennement</li>
          <li>Consultez un professionnel si les symptômes persistent</li>
          <li>Prévoyez des périodes de récupération</li>
        </ul>
      </div>
    </div>

    <!-- Burn-out (charge mentale à 10) -->
    <div v-else-if="outcome === 'failure'" class="result result-failure">
      <h2>🔥 Burn-out détecté</h2>
      <p>Votre charge mentale a atteint un niveau critique. Il est essentiel de faire une pause et de chercher du soutien.</p>

      <div class="emergency-resources">
        <h3>📚 Trouver de l'aide</h3>

        <h4>🧠 Permanences en ligne et téléphoniques</h4>
        <ul>
          <li><strong><a href="https://www.147.ch" target="_blank">147.ch</a></strong> – Ligne gratuite 24h/24 pour les jeunes (téléphone, chat, SMS, e-mail).</li>
          <li><strong><a href="https://www.ontecoute.ch" target="_blank">Ontecoute.ch</a></strong> – Questions anonymes aux professionnel·le·s, forum, adresses utiles.</li>
        </ul>

        <h4>🏥 Associations romandes de soutien</h4>
        <ul>
          <li><strong><a href="https://www.santepsy.ch" target="_blank">SantéPsy</a></strong> – Infos et outils pour mieux gérer les difficultés psychiques.</li>
          <li><strong><a href="https://www.noburnout.ch" target="_blank">No burnout</a></strong> – Évaluation personnelle et prévention de l'épuisement professionnel.</li>
        </ul>

        <h4>🎓 Ressources étudiantes à la HEIG-VD</h4>
        <ul>
          <li><strong>Service de santé</strong> – Infirmières disponibles pour vous accueillir, évaluer et orienter.</li>
          <li><strong>Aumônerie</strong> – Service d'écoute et de dialogue interreligieux/interculturel.</li>
        </ul>
      </div>
    </div>

    <!-- Crise de sommeil (sommeil à 0) -->
    <div v-else-if="outcome === 'sleep-crisis'" class="result result-sleep">
      <h2>😴 Épuisement physique</h2>
      <p>Vous vous êtes littéralement endormi(e) en cours. Le manque de sommeil a eu raison de vous.</p>
      
      <div class="scenario-description">
        <p>Lundi, 10h30. Au milieu du cours de programmation, votre tête s'est mise à dodeliner. Malgré vos efforts, vos paupières sont devenues trop lourdes. Vous vous êtes effondré(e) sur votre clavier, sous le regard inquiet de vos camarades.</p>
        <p>L'infirmière de l'école vous a placé(e) en observation à l'infirmerie. Verdict : épuisement sévère dû à un manque chronique de sommeil.</p>
      </div>
      
      <div class="advice-box">
        <h3>Importance du sommeil pour les étudiants</h3>
        <ul>
          <li><strong>Consolidation de la mémoire</strong> - Le sommeil est essentiel pour intégrer les connaissances acquises pendant la journée</li>
          <li><strong>Capacité de concentration</strong> - La privation de sommeil diminue considérablement vos facultés d'attention</li>
          <li><strong>Système immunitaire</strong> - Un sommeil insuffisant vous rend plus vulnérable aux maladies</li>
          <li><strong>Gestion du stress</strong> - Dormir permet de réguler les hormones du stress</li>
        </ul>
      </div>
    </div>

    <!-- Crise académique (notes à 0) -->
    <div v-else-if="outcome === 'academic-crisis'" class="result result-academic">
      <h2>📉 Échec académique</h2>
      <p>Vos notes se sont effondrées au point que vous ne pouvez plus valider votre semestre.</p>
      
      <div class="scenario-description">
        <p>Le conseil des professeurs vient de se réunir pour examiner votre situation académique. Le verdict est sans appel : vos résultats sont insuffisants pour continuer.</p>
        <p>Une réorientation ou un redoublement sont désormais à envisager. Le conseiller aux études vous invite à le rencontrer pour discuter des options.</p>
      </div>
      
      <div class="advice-box">
        <h3>Rebondir après un échec académique</h3>
        <ul>
          <li><strong>Analyser les causes</strong> - Identifier ce qui a conduit à cette situation</li>
          <li><strong>Demander de l'aide</strong> - Consulter les services d'orientation et les conseillers académiques</li>
          <li><strong>Redéfinir ses objectifs</strong> - Parfois, un échec est l'occasion de repenser son parcours</li>
          <li><strong>Améliorer sa méthode</strong> - Revoir ses techniques d'apprentissage et d'organisation</li>
          <li><strong>Garder confiance</strong> - Un échec n'est pas une fatalité mais une étape d'apprentissage</li>
        </ul>
      </div>
    </div>

    <!-- Message d'erreur par défaut -->
    <div v-else class="result result-error">
      <h2>⚠️ Une erreur s'est produite</h2>
      <p>Nous ne pouvons pas afficher le résultat demandé.</p>
    </div>

    <!-- Boutons d'action -->
    <div class="result-actions">
      <router-link to="/" class="button primary">Retour à l'accueil</router-link>
      <button @click="restartGame" class="button secondary">Réessayer</button>
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
<template>
    <main>
      <div v-if="outcome === 'success'" class="result-success">
  <h2>🏆 Succès Total !</h2>
  <p>Félicitations ! Vous avez brillamment géré le stress et maintenu votre équilibre mental. Votre résilience est remarquable !</p>
  <div class="achievement">
    <span>🌟 Déverrouillé : Maître de la Sérénité</span>
  </div>
</div>

<div v-else-if="outcome === 'warning'" class="result-warning">
  <h2>⚠️ Proche du Burn-out</h2>
  <p>Vous avez frôlé l'épuisement. Bien que vous ayez survécu, il est crucial de prendre soin de votre santé mentale.</p>
  <div class="advice">
    <h3>Conseils de Prévention :</h3>
    <ul>
      <li>Établissez des limites claires</li>
      <li>Pratiquez la pleine conscience</li>
      <li>Consultez un professionnel si nécessaire</li>
    </ul>
  </div>
</div>

<div v-else-if="outcome === 'failure'" class="result-failure">
  <h2>🔥 Burn-out Détecté</h2>
  <p>Votre charge mentale a atteint un niveau critique. Il est essentiel de faire une pause et de chercher du soutien.</p>

  <div class="emergency-resources">
    <br>
    <h3>📚 Trouver de l'aide</h3>

    <h4>🧠 Permanences en ligne et téléphoniques</h4>
    <ul>
      <li><strong><a href="https://www.147.ch" target="_blank">147.ch</a></strong> – Ligne gratuite 24h/24 pour les jeunes (téléphone, chat, SMS, e-mail).</li>
      <li><strong><a href="https://www.ontecoute.ch" target="_blank">Ontecoute.ch</a></strong> – Questions anonymes aux professionnel·le·s, forum, adresses utiles.</li>
    </ul>

    <h4>🏥 Associations romandes de soutien</h4>
    <ul>
      <li><strong>Association Ciao</strong> – Aide ponctuelle et orientation vers des services spécialisés.</li>
      <li><strong><a href="https://www.santepsy.ch" target="_blank">SantéPsy</a></strong> – Infos et outils pour mieux gérer les difficultés psychiques.</li>
      <li><strong><a href="https://www.noburnout.ch" target="_blank">No burnout</a></strong> – Évaluation personnelle et prévention de l'épuisement professionnel.</li>
      <li><strong><a href="https://www.stressnostress.ch" target="_blank">stressnostress.ch</a></strong> – Portail de la FSP sur les risques liés au stress.</li>
      <li><strong><a href="https://www.seco.admin.ch/seco/fr/home/Arbeit/Arbeitsbedingungen/Gesundheitsschutz/Burnout.html" target="_blank">Brochure SECO</a></strong> – Détection précoce et prévention du burn-out (PDF gratuit).</li>
      <li><strong><a href="https://www.avpsy.ch" target="_blank">Association vaudoise des psychologues</a></strong> – Répertoire de psychologues selon divers critères.</li>
    </ul>

    <h4>🎓 Ressources étudiantes à la HEIG-VD</h4>
    <ul>
      <li><strong>Service de santé</strong> – Infirmières disponibles pour vous accueillir, évaluer et orienter.</li>
      <li><strong>Aumônerie</strong> – Service d’écoute et de dialogue interreligieux/interculturel.</li>
      <li><strong>ASSIDE</strong> – Association interfilière des étudiant·es, relais vers la direction.</li>
      <li><strong>REACHED</strong> – Lutte contre le harcèlement sexuel et accompagnement étudiant.</li>
    </ul>
<br>

    <h4>🧑‍⚕️ Soutien psychologique – HEIG-VD</h4>
    <p>Les consultations psychologiques sont gratuites pour les étudiant·es. La confidentialité est garantie, tant pour la prise de contact que pour les entretiens.</p>
<br>
    <p><strong>Psychologue de référence :</strong></p>
    <p>
      <strong>Danièle Mügeli Ardia</strong><br>
      Psychologue-psychothérapeute FSP<br>
      Rue des Pêcheurs 8d, 1400 Yverdon-les-Bains<br>
      <a href="mailto:daniele.muegeliardia@psychologie.ch">daniele.muegeliardia@psychologie.ch</a><br>
      024 425 62 22
    </p>
  </div>
</div>



<div v-else class="result-error">
  <p>Une erreur s'est produite. Veuillez réessayer.</p>
</div>

<router-link to="/" class="button">Retour à l'accueil</router-link>
    </main>
  </template>
  
  <script setup>
 import { computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const outcome = computed(() => route.params.outcome);

  </script>
  
  <style scoped>
  .result-container {
    text-align: center;
  }
  h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
  }
  p {
    font-size: 1.5rem;
    margin-top: 20px;
  }
  .button {
    display: inline-block;
    background-color: #a5d6a7;
    color: white;
    padding: 10px 20px;
    font-size: 1.2rem;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 30px;
    text-decoration: none;
  }
  .button:hover {
    background-color: #81c784;
  }
  </style>
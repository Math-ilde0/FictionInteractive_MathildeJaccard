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
  <p>Votre niveau de stress a atteint un point critique. Il est urgent de prendre soin de vous.</p>
  <div class="emergency-resources">
    <h3>Ressources d'Aide :</h3>
    <ul>
      <li>📞 Ligne d'écoute : 0800 STRESS</li>
      <li>💻 Sites de soutien psychologique</li>
      <li>👥 Groupes de support</li>
    </ul>
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
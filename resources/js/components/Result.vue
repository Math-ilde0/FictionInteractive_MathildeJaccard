<template>
    <main>
      <div class="book-page result-container">
        <h1>Résultat de l'histoire</h1>
        <p v-if="outcome === 'success'">
          Bravo, vous avez échappé au burn-out ! Vous avez su gérer vos choix avec sagesse. Félicitations !
        </p>
        <p v-else-if="outcome === 'failure'">
          Vous êtes en burn-out. Si vous avez besoin d'aide, contactez un professionnel de santé. Prenez soin de vous.
        </p>
        <p v-else>
          Une erreur s'est produite. Veuillez réessayer.
        </p>
        <router-link to="/" class="button">Retour à l'accueil</router-link>
      </div>
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
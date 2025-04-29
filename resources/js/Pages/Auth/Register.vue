<template>
    <div class="auth-container">
      <h1>Créer un compte</h1>
      <form @submit.prevent="submit">
        <input v-model="name" type="text" placeholder="Nom" required />
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Mot de passe" required />
        <input v-model="password_confirmation" type="password" placeholder="Confirmer le mot de passe" required />
        <button type="submit">Créer mon compte</button>
      </form>
      <router-link to="/login">Déjà inscrit ? Se connecter</router-link>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const name = ref('');
  const email = ref('');
  const password = ref('');
  const password_confirmation = ref('');
  const router = useRouter();
  
  const submit = async () => {
    try {
      await axios.post('/register', { name: name.value, email: email.value, password: password.value, password_confirmation: password_confirmation.value });
      router.push('/stories');
    } catch (error) {
      alert('Erreur lors de la création du compte');
      console.error(error);
    }
  };
  </script>
  
  <style scoped>
  /* Ajoute du style propre ici si besoin */
  </style>
  
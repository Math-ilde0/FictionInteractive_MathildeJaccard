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
    // Obtenez d'abord le cookie CSRF
    await axios.get('/sanctum/csrf-cookie');
    console.log('CSRF cookie obtenu');
    
    await new Promise(resolve => setTimeout(resolve, 300))
    
    console.log('Envoi requête inscription...');
    const response = await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });
    
    // Vérifier si l'inscription a réussi
    if (response.data && response.data.user) {
      router.push('/testimonies');
    } else {
      console.warn('Inscription réussie mais format de réponse inattendu', response);
      router.push('/testimonies');
    }
  }catch (error) {
    // More detailed error handling
    if (error.response) {
      // The request was made and the server responded with a status code
      // that falls out of the range of 2xx
      const errors = error.response.data.errors;
      if (errors) {
        // Laravel validation errors
        let errorMessage = Object.values(errors).flat().join('\n');
        alert(errorMessage);
      } else {
        // Generic server error
        alert(error.response.data.message || 'Erreur lors de la création du compte');
      }
    } else if (error.request) {
      // The request was made but no response was received
      alert('Pas de réponse du serveur. Vérifiez votre connexion.');
    } else {
      // Something happened in setting up the request that triggered an Error
      alert('Erreur lors de la préparation de la requête');
    }
    console.error('Registration error:', error);
  }
};
  </script>
  
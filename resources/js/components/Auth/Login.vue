<template>
    <div>
      <h2>Connexion</h2>
      <form @submit.prevent="submitLogin">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Mot de passe" required />
        <button type="submit">Se connecter</button>
      </form>
      <router-link to="/register">Pas encore inscrit ? Créer un compte</router-link>
    </div>
  </template>
  
  <script setup>
import { ref } from 'vue';
import { login } from '/resources/js/auth.js'; // Fix this path
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const router = useRouter();

const submitLogin = async () => {
  try {
    const credentials = {
      email: email.value,
      password: password.value
    };

    const success = await login(credentials);
    if (success) {
      router.push('/testimonies');
    } else {
      alert('Erreur lors de la connexion');
    }
  } catch (error) {
    console.error('Erreur de connexion', error);
    alert('Erreur lors de la connexion');
  }
};
</script>
  
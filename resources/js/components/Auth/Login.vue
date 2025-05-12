<template>

  <div class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center px-4">
  
  <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6">
  
  <h2 class="text-2xl font-bold text-center text-blue-700">Connexion</h2>
  
  <form @submit.prevent="submitLogin" class="space-y-4">
  
  <!-- Bouton Retour à l'accueil -->
  
  <div class="text-center mt-4">
  
  <button
  
  @click="goHome"
  
  class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-indigo-700 transition"
  
  >
  
  🏠 Retour à l'accueil
  
  </button>
  
  </div>
  
  <input
  
  v-model="email"
  
  type="email"
  
  placeholder="Email"
  
  required
  
  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
  
  />
  
  <input
  
  v-model="password"
  
  type="password"
  
  placeholder="Mot de passe"
  
  required
  
  minlength="8"
  
  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
  
  />
  
  <button
  
  type="submit"
  
  :disabled="isSubmitting"
  
  class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold disabled:opacity-50"
  
  >
  
  {{ isSubmitting ? 'Connexion en cours...' : 'Se connecter' }}
  
  </button>
  
  </form>
  
  <div class="text-center text-sm text-gray-600 mt-6">
  
  <router-link to="/register" class="inline-flex items-center gap-2 text-blue-600 hover:underline">
  
  🔼 Pas encore inscrit ? Créer un compte
  
  </router-link>
  
  </div>
  
  </div>
  
  </div>
  
  </template>
  
  <script setup>
  
  import { ref } from 'vue';
  
  import axios from 'axios';
  
  import { useRouter } from 'vue-router';
  
  import { login, fetchUser } from '@/auth.js';
  
  import { showNotification } from '@/stores/notificationStore';
  
  const email = ref('');
  
  const password = ref('');
  
  const isSubmitting = ref(false);
  
  const router = useRouter();
  
  const submitLogin = async () => {
  
  if (isSubmitting.value) return;
  
  try {
  
  isSubmitting.value = true;
  
  await axios.get('/sanctum/csrf-cookie');
  
  const credentials = {
  
  email: email.value,
  
  password: password.value
  
  };
  
  const response = await axios.post('/login', credentials);
  
  if (response.status === 200) {
  
  await fetchUser();
  
  await showNotification({
  
  type: 'success',
  
  message: 'Connexion réussie ! Redirection...',
  
  duration: 2000
  
  });
  
  router.push('/testimonies');
  
  } else {
  
  throw new Error('Connexion échouée');
  
  }
  
  } catch (error) {
  
  console.error('Erreur de connexion', error);
  
  const errorMessage = error.response?.data?.message
  
  || 'Impossible de se connecter. Vérifiez vos identifiants.';
  
  showNotification({
  
  type: 'error',
  
  title: 'Echec de connexion',
  
  message: errorMessage,
  
  duration: 0
  
  });
  
  } finally {
  
  isSubmitting.value = false;
  
  }
  
  };
  
  const goHome = () => {
  
  router.push('/');
  
  };
  
  </script>
<template>

  <div class="min-h-screen bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center px-4">
  
  <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6">
  
  <h1 class="text-2xl font-bold text-center text-indigo-700">Créer un compte</h1>
  
  <form @submit.prevent="submit" class="space-y-4">
  
  <div class="text-center mt-4">
  
  <button
  
  @click="goHome"
  
  class="inline-flex items-center gap-2 text-sm text-gray-700 hover:text-indigo-700 transition"
  
  >
  
  🏠 Retour à l'accueil
  
  </button>
  
  </div>
  
  <input
  
  v-model="name"
  
  type="text"
  
  placeholder="Nom"
  
  required
  
  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
  
  />
  
  <input
  
  v-model="email"
  
  type="email"
  
  placeholder="Email"
  
  required
  
  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
  
  />
  
  <input
  
  v-model="password"
  
  type="password"
  
  placeholder="Mot de passe"
  
  required
  
  minlength="8"
  
  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
  
  />
  
  <input
  
  v-model="password_confirmation"
  
  type="password"
  
  placeholder="Confirmer le mot de passe"
  
  required
  
  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300"
  
  />
  
  <button
  
  type="submit"
  
  :disabled="isSubmitting"
  
  class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold"
  
  >
  
  {{ isSubmitting ? 'Création en cours...' : 'Créer mon compte' }}
  
  </button>
  
  <!-- Ligne d'info ajoutée -->
  
  <p class="text-xs text-center text-gray-500 mt-2">
  
  ⚠️ Si la redirection vers les témoignages ne fonctionne pas et que le bouton indique "creation en cours" depuis trop longtemps, connectez-vous manuellement avec l'email et le mot de passe que vous venez d'indiquer.
  
  </p>
  
  </form>
  
  <div class="text-center text-sm text-gray-600 mt-6">
  
  <router-link to="/login" class="inline-flex items-center gap-2 text-indigo-600 hover:underline">
  
  🔼 Retourner vers "Se connecter"
  
  </router-link>
  
  </div>
  
  </div>
  
  </div>
  
  </template>
  
  <script setup>
  
  import { ref } from 'vue';
  
  import axios from 'axios';
  
  import { useRouter } from 'vue-router';
  
  import { showNotification } from '@/stores/notificationStore';
  
  import { fetchUser } from '@/auth';
  
  const name = ref('');
  
  const email = ref('');
  
  const password = ref('');
  
  const password_confirmation = ref('');
  
  const isSubmitting = ref(false);
  
  const router = useRouter();
  
  const submit = async () => {
  
  if (isSubmitting.value) return;
  
  if (password.value !== password_confirmation.value) {
  
  await showNotification({
  
  type: 'error',
  
  message: 'Les mots de passe ne correspondent pas',
  
  duration: 3000
  
  });
  
  return;
  
  }
  
  try {
  
  isSubmitting.value = true;
  
  await axios.get('/sanctum/csrf-cookie');
  
  const response = await axios.post('/register', {
  
  name: name.value,
  
  email: email.value,
  
  password: password.value,
  
  password_confirmation: password_confirmation.value
  
  });
  
  if ([200, 201, 204].includes(response.status)) {
  
  await fetchUser();
  
  await showNotification({
  
  type: 'success',
  
  message: 'Compte créé avec succès ! Redirection...',
  
  duration: 2000
  
  });
  
  router.push('/testimonies');
  
  } else {
  
  throw new Error('Inscription échouée');
  
  }
  
  } catch (error) {
  
  console.error("Erreur lors de l'inscription:", error);
  
  let errorMessage = 'Une erreur est survenue lors de la création du compte.';
  
  if (error.response?.data?.errors) {
  
  errorMessage = Object.values(error.response.data.errors).flat().join('\n');
  
  } else if (error.response?.data?.message) {
  
  errorMessage = error.response.data.message;
  
  }
  
  await showNotification({
  
  type: 'error',
  
  title: "Erreur d'inscription",
  
  message: errorMessage,
  
  duration: 5000
  
  });
  
  } finally {
  
  isSubmitting.value = false;
  
  }
  
  };
  
  const goHome = () => {
  
  router.push('/');
  
  };
  
  </script>
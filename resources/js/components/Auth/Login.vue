<template>
  <div>
    <h2>Connexion</h2>
    <form @submit.prevent="submitLogin">
      <input 
  v-model="email" 
  type="email" 
  placeholder="Email" 
  required 
/>
      <input 
  v-model="password" 
  type="password" 
  placeholder="Mot de passe" 
  required 
  minlength="8"
/>
<button 
          type="submit" 
          :disabled="isSubmitting"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
        >
          {{ isSubmitting ? 'Connexion en cours...' : 'Se connecter' }}
        </button>
    </form>
    <router-link to="/register">Pas encore inscrit ? Créer un compte</router-link>
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
      title: 'Échec de connexion',
      message: errorMessage,
      duration: 0
    });
  } finally {
    isSubmitting.value = false;
  }
};
</script>

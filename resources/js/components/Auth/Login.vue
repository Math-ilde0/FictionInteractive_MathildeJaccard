<template>
  <div>
    <h2>Connexion</h2>
    <form @submit.prevent="submitLogin">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Mot de passe" required />
      <button type="submit" :disabled="isSubmitting">
        <span v-if="isSubmitting">Connexion en cours...</span>
        <span v-else>Se connecter</span>
      </button>
    </form>
    <router-link to="/register">Pas encore inscrit ? Créer un compte</router-link>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { login } from '@/auth.js';
import { useRouter } from 'vue-router';
import { showNotification } from  '@/stores/notificationStore';

const email = ref('');
const password = ref('');
const isSubmitting = ref(false);
const router = useRouter();

const submitLogin = async () => {
  console.log('Tentative de connexion avec:', { email: email.value });
  if (isSubmitting.value) return;
  
  try {
    isSubmitting.value = true;
    
    const credentials = {
      email: email.value,
      password: password.value
    };

    const success = await login(credentials);
    
    if (success) {
      await showNotification({
        type: 'success',
        message: 'Connexion réussie ! Redirection...',
        duration: 2000
      });
      
      router.push('/testimonies');
    } else {
      showNotification({
        type: 'error',
        title: 'Échec de connexion',
        message: 'Email ou mot de passe incorrect.',
        duration: 0 // Ne pas disparaître automatiquement
      });
    }
  } catch (error) {
    console.error('Erreur de connexion', error);
    
    showNotification({
      type: 'error',
      title: 'Erreur de connexion',
      message: 'Impossible de se connecter au serveur. Veuillez réessayer plus tard.',
      action: true,
      actionText: 'Réessayer'
    }).then(result => {
      if (result === 'action') {
        submitLogin();
      }
    });
  } finally {
    isSubmitting.value = false;
  }
};
</script>
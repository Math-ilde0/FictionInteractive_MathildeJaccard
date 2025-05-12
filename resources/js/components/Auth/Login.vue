<template>
  <div>
    <h2>Connexion</h2>
    
    <!-- Formulaire de connexion -->
    <form @submit.prevent="submitLogin">
      <!-- Champ email -->
      <input 
        v-model="email" 
        type="email" 
        placeholder="Email" 
        required 
      />

      <!-- Champ mot de passe -->
      <input 
        v-model="password" 
        type="password" 
        placeholder="Mot de passe" 
        required 
        minlength="8"
      />

      <!-- Bouton de soumission -->
      <button 
        type="submit" 
        :disabled="isSubmitting"
        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
      >
        {{ isSubmitting ? 'Connexion en cours...' : 'Se connecter' }}
      </button>
    </form>

    <!-- Lien vers l'inscription -->
    <router-link to="/register">Pas encore inscrit ? Créer un compte</router-link>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

// Fonctions personnalisées pour la session utilisateur et les notifications
import { login, fetchUser } from '@/auth.js';
import { showNotification } from '@/stores/notificationStore';

// Références réactives pour les champs du formulaire
const email = ref('');
const password = ref('');
const isSubmitting = ref(false);

const router = useRouter();

// Fonction appelée lors de la soumission du formulaire
const submitLogin = async () => {
  if (isSubmitting.value) return;

  try {
    isSubmitting.value = true;

    // Récupération du cookie CSRF nécessaire pour Laravel Sanctum
    await axios.get('/sanctum/csrf-cookie');

    // Préparation des identifiants à envoyer
    const credentials = {
      email: email.value,
      password: password.value
    };

    // Envoi de la requête POST à /login
    const response = await axios.post('/login', credentials);

    // Si la connexion est réussie, on récupère l'utilisateur
    if (response.status === 200) {
      await fetchUser();

      // Affichage d'une notification de succès
      await showNotification({
        type: 'success',
        message: 'Connexion réussie ! Redirection...',
        duration: 2000
      });

      // Redirection vers la page de témoignages
      router.push('/testimonies');
    } else {
      throw new Error('Connexion échouée');
    }
  } catch (error) {
    console.error('Erreur de connexion', error);

    // Affichage d'une notification d'erreur
    const errorMessage = error.response?.data?.message
      || 'Impossible de se connecter. Vérifiez vos identifiants.';

    showNotification({
      type: 'error',
      title: 'Échec de connexion',
      message: errorMessage,
      duration: 0
    });
  } finally {
    // Réinitialise le bouton
    isSubmitting.value = false;
  }
};
</script>

<template>
    <div class="auth-container">
      <h1>Créer un compte</h1>
      <form @submit.prevent="submit">
        <input v-model="name" type="text" placeholder="Nom" required />
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Mot de passe" required />
        <input v-model="password_confirmation" type="password" placeholder="Confirmer le mot de passe" required />
        <button type="submit" :disabled="isSubmitting">
          {{ isSubmitting ? 'Création en cours...' : 'Créer mon compte' }}
        </button>
      </form>
      <router-link to="/login">Déjà inscrit ? Se connecter</router-link>
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
  const router = useRouter();
  const isSubmitting = ref(false);
  
  const submit = async () => {
    if (isSubmitting.value) return;
    
    try {
      isSubmitting.value = true;
      
      // Obtenir le cookie CSRF
      await axios.get('/sanctum/csrf-cookie');
      
      // Envoyer la requête d'inscription
      const response = await axios.post('/register', {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value
      });
      
      // Vérifier si l'inscription a réussi
      if (response.data && response.data.user) {
        // Mettre à jour l'état de l'utilisateur
        await fetchUser();
        
        await showNotification({
          type: 'success',
          message: 'Compte créé avec succès ! Redirection...',
          duration: 2000
        });
        
        // Rediriger vers la page des témoignages
        await router.push('/testimonies');
      } else {
        throw new Error('Format de réponse inattendu');
      }
    } catch (error) {
      console.error('Erreur lors de l\'inscription:', error);
      
      let errorMessage = 'Une erreur est survenue lors de la création du compte.';
      
      if (error.response?.data?.errors) {
        errorMessage = Object.values(error.response.data.errors).flat().join('\n');
      } else if (error.response?.data?.message) {
        errorMessage = error.response.data.message;
      }
      
      await showNotification({
        type: 'error',
        title: 'Erreur d\'inscription',
        message: errorMessage,
        duration: 5000
      });
    } finally {
      isSubmitting.value = false;
    }
  };
  </script>
  
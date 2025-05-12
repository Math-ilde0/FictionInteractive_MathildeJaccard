<template>
  <!-- Conteneur principal pour l'inscription -->
  <div class="auth-container">
    <h1>Créer un compte</h1>

    <!-- Formulaire d'inscription -->
    <form @submit.prevent="submit">
      <!-- Champ nom -->
      <input v-model="name" type="text" placeholder="Nom" required />

      <!-- Champ email -->
      <input v-model="email" type="email" placeholder="Email" required />

      <!-- Champ mot de passe -->
      <input v-model="password" type="password" placeholder="Mot de passe" required minlength="8" />

      <!-- Champ confirmation de mot de passe -->
      <input v-model="password_confirmation" type="password" placeholder="Confirmer le mot de passe" required />

      <!-- Bouton de soumission -->
      <button type="submit" :disabled="isSubmitting">
        {{ isSubmitting ? 'Création en cours...' : 'Créer mon compte' }}
      </button>
    </form>

    <!-- Lien vers la page de connexion -->
    <router-link to="/login">Déjà inscrit ? Se connecter</router-link>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

// Fonction d'affichage des notifications
import { showNotification } from '@/stores/notificationStore';

// Fonction pour récupérer l'utilisateur une fois connecté
import { fetchUser } from '@/auth';

// Champs réactifs pour le formulaire
const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const isSubmitting = ref(false);

const router = useRouter();

// Fonction de soumission du formulaire
const submit = async () => {
  // Empêche la soumission multiple
  if (isSubmitting.value) return;

  // Vérifie si les mots de passe correspondent
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

    // Récupère le cookie CSRF pour Laravel Sanctum
    await axios.get('/sanctum/csrf-cookie');

    // Envoie les données du formulaire au backend
    const response = await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });

    // Si succès, récupérer l'utilisateur et rediriger
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
    console.error('Erreur lors de l\'inscription:', error);

    // Prépare le message d'erreur selon la réponse de l'API
    let errorMessage = 'Une erreur est survenue lors de la création du compte.';

    if (error.response?.data?.errors) {
      errorMessage = Object.values(error.response.data.errors).flat().join('\n');
    } else if (error.response?.data?.message) {
      errorMessage = error.response.data.message;
    }

    // Affiche une notification d'erreur
    await showNotification({
      type: 'error',
      title: 'Erreur d\'inscription',
      message: errorMessage,
      duration: 5000
    });
  } finally {
    // Réactive le bouton
    isSubmitting.value = false;
  }
};
</script>

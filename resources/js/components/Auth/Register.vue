<template>
    <div class="auth-container">
      <h1>Créer un compte</h1>
      <form @submit.prevent="submit">
        <input v-model="name" type="text" placeholder="Nom" required />
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
  
  // Validation côté client
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
    
    // Obtenir le cookie CSRF
    await axios.get('/sanctum/csrf-cookie');
    
    const response = await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });
    
    // Vérifier explicitement la réponse
    if (response.status === 200 || response.status === 201 || response.status === 204) {
  await fetchUser(); // tente de récupérer l'utilisateur connecté
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
  console.error('Erreur lors de l\'inscription:', error); // Garde cette ligne

  // 👇 Ajoute ça temporairement pour afficher le contenu brut :
  if (error.response) {
    console.log('Réponse complète du backend :', error.response);
    console.log('Contenu (data) :', error.response.data);
  }

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
  })
}
}
  </script>
  
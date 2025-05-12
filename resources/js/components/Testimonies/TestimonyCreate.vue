<template>
  <div class="testimony-create-container">
    <h1 class="text-2xl font-bold mb-6">Partager mon témoignage</h1>
    
    <form @submit.prevent="submitTestimony" class="max-w-lg mx-auto">
      <div class="mb-4">
        <label for="title" class="block mb-2">Titre du témoignage</label>
        <input 
          v-model="title" 
          type="text" 
          id="title" 
          required 
          class="w-full p-2 border rounded"
          placeholder="Un titre court et significatif"
        />
      </div>
      
      <div class="mb-4">
        <label for="content" class="block mb-2">Votre témoignage</label>
        <textarea 
          v-model="content" 
          id="content" 
          required 
          rows="6" 
          class="w-full p-2 border rounded"
          placeholder="Partagez votre expérience avec la charge mentale..."
        ></textarea>
      </div>
      
      <button 
        type="submit" 
        class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600"
        disabled
      >
        <span v-if="isSubmitting">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Envoi en cours...
        </span>
        <span v-else>Publier mon témoignage</span>
      </button>
    </form>
  </div>
</template><script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { showNotification } from '@/stores/notificationStore';

const title = ref('');
const content = ref('');
const isSubmitting = ref(false);
const router = useRouter();

const submitTestimony = async () => {
  if (isSubmitting.value) return;
  
  try {
    isSubmitting.value = true;
    
    // Debugging
    console.log('Début de la soumission du témoignage');
    
    // Get CSRF cookie first
    console.log('Récupération du cookie CSRF...');
    await axios.get('/sanctum/csrf-cookie');
    
    console.log('Envoi du témoignage...');
    // Envoi explicite avec withCredentials pour s'assurer que les cookies sont envoyés
    const response = await axios.post('/api/testimonies', {
      title: title.value,
      content: content.value
    }, {
      withCredentials: true,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    
    console.log('Réponse du serveur:', response);
    
    // Success
    await showNotification({
      type: 'success',
      title: 'Témoignage publié !',
      message: 'Votre témoignage a été soumis avec succès.',
      duration: 3000
    });
    
    router.push('/testimonies');
  } catch (error) {
    console.error('Erreur détaillée lors de la publication:', {
      message: error.message,
      status: error.response?.status,
      statusText: error.response?.statusText,
      data: error.response?.data,
      headers: error.response?.headers
    });
    
    let errorMessage = 'Impossible de publier le témoignage. Réessayez.';
    
    if (error.response?.data?.message) {
      errorMessage = error.response.data.message;
    } else if (error.response?.data?.errors) {
      errorMessage = Object.values(error.response.data.errors).flat().join('\n');
    } else if (error.request) {
      errorMessage = 'Problème de connexion. Vérifiez votre réseau.';
    }
    
    if (error.response?.status === 401) {
      errorMessage = "Vous n'êtes pas connecté. Veuillez vous connecter pour publier un témoignage.";
      // Rediriger vers la page de connexion
      router.push('/login');
    }
    
    showNotification({
      type: 'error',
      title: 'Erreur de publication',
      message: errorMessage,
      action: true,
      actionText: 'Réessayer'
    }).then(result => {
      if (result === 'action') {
        submitTestimony();
      }
    });
  } finally {
    isSubmitting.value = false;
  }
};
</script>
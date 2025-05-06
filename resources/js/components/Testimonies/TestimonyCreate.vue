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
          :disabled="isSubmitting"
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
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const title = ref('');
  const content = ref('');
  const isSubmitting = ref(false);
  const router = useRouter();
  
  const submitTestimony = async () => {
    if (isSubmitting.value) return;
    
    try {
      isSubmitting.value = true;
      
      // Use the correct endpoint - remove /api prefix if needed based on your API setup
      await axios.get('/sanctum/csrf-cookie');
      await axios.post('/testimonies', {
  title: title.value,
  content: content.value
});
      
      // Success! Redirect to testimonies list
      router.push('/testimonies');
    } catch (error) {
      console.error('Erreur lors de la publication:', error);
      let errorMessage = 'Impossible de publier le témoignage. Réessayez.';
      
      // Show more specific error message if available
      if (error.response?.data?.message) {
        errorMessage = error.response.data.message;
      } else if (error.response?.data?.errors) {
        errorMessage = Object.values(error.response.data.errors).flat().join('\n');
      }
      
      alert(errorMessage);
    } finally {
      isSubmitting.value = false;
    }
  };
  </script>
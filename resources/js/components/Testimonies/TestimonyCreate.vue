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
        >
          Publier mon témoignage
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
  const router = useRouter();
  
  const submitTestimony = async () => {
    try {
      await axios.post('/api/testimonies', {
        title: title.value,
        content: content.value
      });
      
      router.push('/testimonies');
    } catch (error) {
      console.error('Erreur lors de la publication:', error);
      alert('Impossible de publier le témoignage. Réessayez.');
    }
  };
  </script>
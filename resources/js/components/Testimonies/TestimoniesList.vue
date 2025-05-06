<template>
  <div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Témoignages sur la charge mentale</h1>
    
    <div v-if="isAuthenticated" class="text-center mb-8">
      <router-link 
        to="/testimonies/create" 
        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors inline-block"
      >
        Partager mon témoignage
      </router-link>
    </div>
    
    <div v-if="loading" class="text-center py-8 text-gray-500">
      Chargement des témoignages...
    </div>
    
    <div v-else-if="error" class="bg-red-100 text-red-700 p-4 rounded-lg text-center">
      {{ error }}
    </div>
    
    <div v-else-if="testimonies.length === 0" class="text-center py-8 text-gray-500 italic">
      Aucun témoignage n'a encore été publié.
    </div>
    
    <div v-else class="space-y-6">
      <div v-for="testimony in testimonies" :key="testimony.id" class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-3 text-gray-800">{{ testimony.title }}</h2>
        <div class="flex justify-between text-sm text-gray-500 mb-4">
          <span>Par {{ testimony.user.name }}</span>
          <span>{{ formatDate(testimony.created_at) }}</span>
        </div>
        <p class="text-gray-700 mb-4 leading-relaxed">{{ excerpt(testimony.content) }}</p>
        <router-link :to="`/testimonies/${testimony.id}`" class="text-green-600 font-medium hover:underline">
          Lire la suite
        </router-link>
      </div>
    </div>
    
    <div v-if="totalPages > 1" class="flex items-center justify-center gap-4 mt-8">
      <button 
        @click="changePage(currentPage - 1)" 
        :disabled="currentPage === 1"
        class="bg-gray-200 px-4 py-2 rounded disabled:opacity-50 hover:bg-gray-300 disabled:hover:bg-gray-200"
      >
        Précédent
      </button>
      <span class="text-gray-600">Page {{ currentPage }} sur {{ totalPages }}</span>
      <button 
        @click="changePage(currentPage + 1)" 
        :disabled="currentPage === totalPages"
        class="bg-gray-200 px-4 py-2 rounded disabled:opacity-50 hover:bg-gray-300 disabled:hover:bg-gray-200"
      >
        Suivant
      </button>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { user } from '/resources/js/auth.js';
import axios from 'axios';

export default {
  setup() {
    const testimonies = ref([]);
    const loading = ref(true);
    const error = ref(null);
    const currentPage = ref(1);
    const totalPages = ref(1);
    
    const isAuthenticated = computed(() => !!user.value);
    
    const fetchTestimonies = async (page = 1) => {
      loading.value = true;
      error.value = null;
      
      try {
        const response = await axios.get(`/api/testimonies?page=${page}`);
        testimonies.value = response.data.data;
        currentPage.value = response.data.current_page;
        totalPages.value = response.data.last_page;
      } catch (err) {
        error.value = "Aucun témoignage trouvé.";
        console.error(err);
      } finally {
        loading.value = false;
      }
    };
    
    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchTestimonies(page);
        window.scrollTo(0, 0);
      }
    };
    
    const formatDate = (dateString) => {
      const date = new Date(dateString);
      return new Intl.DateTimeFormat('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }).format(date);
    };
    
    const excerpt = (text, length = 200) => {
      if (text.length <= length) return text;
      return text.substring(0, length) + '...';
    };
    
    onMounted(() => {
      fetchTestimonies();
    });
    
    return {
      testimonies,
      loading,
      error,
      isAuthenticated,
      currentPage,
      totalPages,
      changePage,
      formatDate,
      excerpt
    };
  }
};
</script>
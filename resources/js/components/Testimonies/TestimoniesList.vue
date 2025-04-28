<template>
    <div class="testimonies-container">
      <h1 class="testimonies-title">Témoignages sur la charge mentale</h1>
      
      <div v-if="isAuthenticated" class="add-testimony-button">
        <router-link to="/testimonies/create" class="button primary">
          Partager mon témoignage
        </router-link>
      </div>
      <div v-else class="auth-message">
        <router-link to="/login" class="auth-link">Connectez-vous</router-link> ou 
        <router-link to="/register" class="auth-link">inscrivez-vous</router-link> 
        pour partager votre témoignage.
      </div>
      
      <div v-if="loading" class="loading-indicator">
        Chargement des témoignages...
      </div>
      
      <div v-else-if="error" class="error-message">
        {{ error }}
      </div>
      
      <div v-else-if="testimonies.length === 0" class="empty-message">
        Aucun témoignage n'a encore été publié.
      </div>
      
      <div v-else class="testimonies-list">
        <div v-for="testimony in testimonies" :key="testimony.id" class="testimony-card">
          <h2 class="testimony-title">{{ testimony.title }}</h2>
          <div class="testimony-meta">
            <span class="testimony-author">Par {{ testimony.user.name }}</span>
            <span class="testimony-date">{{ formatDate(testimony.created_at) }}</span>
          </div>
          <p class="testimony-excerpt">{{ excerpt(testimony.content) }}</p>
          <router-link :to="`/testimonies/${testimony.id}`" class="read-more-link">
            Lire la suite
          </router-link>
        </div>
      </div>
      
      <div v-if="totalPages > 1" class="pagination">
        <button 
          @click="changePage(currentPage - 1)" 
          :disabled="currentPage === 1"
          class="pagination-button"
        >
          Précédent
        </button>
        <span class="page-info">Page {{ currentPage }} sur {{ totalPages }}</span>
        <button 
          @click="changePage(currentPage + 1)" 
          :disabled="currentPage === totalPages"
          class="pagination-button"
        >
          Suivant
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted, computed } from 'vue';
  import { useAuth } from '@/composables/useAuth';
  import axios from 'axios';
  
  export default {
    setup() {
      const { isAuthenticated } = useAuth();
      const testimonies = ref([]);
      const loading = ref(true);
      const error = ref(null);
      const currentPage = ref(1);
      const totalPages = ref(1);
      
      const fetchTestimonies = async (page = 1) => {
        loading.value = true;
        error.value = null;
        
        try {
          const response = await axios.get(`/api/testimonies?page=${page}`);
          testimonies.value = response.data.data;
          currentPage.value = response.data.current_page;
          totalPages.value = response.data.last_page;
        } catch (err) {
          error.value = "Une erreur est survenue lors du chargement des témoignages.";
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
  
  <style scoped>
  .testimonies-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
  }
  
  .testimonies-title {
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 30px;
    color: #333;
  }
  
  .add-testimony-button {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .button.primary {
    background-color: #66bb6a;
    color: white;
    padding: 12px 25px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s;
  }
  
  .button.primary:hover {
    background-color: #4caf50;
  }
  
  .auth-message {
    text-align: center;
    margin-bottom: 30px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
  }
  
  .auth-link {
    color: #66bb6a;
    text-decoration: none;
    font-weight: bold;
  }
  
  .auth-link:hover {
    text-decoration: underline;
  }
</style>
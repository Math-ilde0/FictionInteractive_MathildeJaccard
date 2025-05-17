<!--
/**
 * @component TestimoniesList.vue
 * Affiche la liste des témoignages publiés par les utilisateurs.
 *
 * Récupère les données via GET `/testimonies/all`.
 * Affiche les noms, titres et dates, avec mise en page responsive.
 * Permet de se déconnecter et d’accéder au formulaire de création (lien désactivé).
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <div class="max-w-3xl mx-auto px-4 py-10">
    <!-- Bouton de déconnexion + retour à l'accueil -->
    <div class="fixed top-5 right-5 z-50">
      <button
        @click="logoutAndGoHome"
        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow flex items-center gap-2"
      >
        Se déconnecter et retourner à l'accueil <span>🏠</span>
      </button>
    </div>

    <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">
      Témoignages sur la charge mentale
    </h1>

    <!-- Bouton pour créer un témoignage si l'utilisateur est connecté -->
    <div v-if="isAuthenticated" class="text-center mb-8">
      <router-link
        to="/testimonies/create"
        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors inline-block"
      >
        Partager mon témoignage (indisponible pour le moment)
      </router-link>
    </div>

    <!-- Chargement en cours -->
    <div v-if="loading" class="text-center py-8 text-gray-500">
      Chargement des témoignages...
    </div>

    <!-- Message d’erreur -->
    <div v-else-if="error" class="bg-red-100 text-red-700 p-4 rounded-lg text-center">
      {{ error }}
    </div>

    <!-- Aucun témoignage trouvé -->
    <div v-else-if="!testimonies || testimonies.length === 0" class="text-center py-8 text-gray-500 italic">
      Aucun témoignage n'a encore été publié.
    </div>

    <!-- Affichage des témoignages -->
    <div v-else class="space-y-6">
      <div
        v-for="(testimony, index) in testimonies"
        :key="testimony?.id || index"
        class="bg-white rounded-lg shadow-md p-6"
      >
        <h2 class="text-xl font-semibold mb-3 text-gray-800">
          {{ testimony?.title || 'Sans titre' }}
        </h2>
        <div class="flex justify-between text-sm text-gray-500 mb-4">
          <span>Par {{ testimony?.user?.name || 'Anonyme' }}</span>
          <span>{{ formatDate(testimony?.created_at) }}</span>
        </div>
        <p class="text-gray-700 mb-4 leading-relaxed">
          {{ excerpt(testimony?.content || '') }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { user, logout } from '@/auth.js';
import axios from 'axios';

export default {
  setup() {
    // Variables réactives pour stocker les témoignages, l’état de chargement et les erreurs
    const testimonies = ref([]);
    const loading = ref(true);
    const error = ref(null);

    // Vérifie si l’utilisateur est connecté
    const isAuthenticated = computed(() => !!user.value);

    // Déconnexion + redirection vers l’accueil
    const logoutAndGoHome = async () => {
      try {
        await logout();
      } catch (error) {
        console.error('Erreur lors de la déconnexion:', error);
      } finally {
        window.location.href = '/';
      }
    };

    // Récupère les témoignages depuis l'API
    const fetchTestimonies = async () => {
      loading.value = true;
      error.value = null;
      try {
        const response = await axios.get('/testimonies/all');
        testimonies.value = response.data;
      } catch (err) {
        error.value = "Aucun témoignage trouvé.";
        console.error(err);
      } finally {
        loading.value = false;
      }
    };

    // Formate une date au format français
    const formatDate = (dateString) => {
      if (!dateString) return '';
      try {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat('fr-FR', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        }).format(date);
      } catch (err) {
        console.error('Erreur de format de date:', err);
        return '';
      }
    };

    // Raccourcit le contenu d’un témoignage
    const excerpt = (text = '', length = 200) => {
      return text.length <= length ? text : text.substring(0, length) + '...';
    };

    // Chargement initial des témoignages
    onMounted(() => {
      fetchTestimonies();
    });

    return {
      testimonies,
      loading,
      error,
      isAuthenticated,
      logoutAndGoHome,
      formatDate,
      excerpt
    };
  }
};
</script>

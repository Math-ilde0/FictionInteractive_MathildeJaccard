<!--
/**
 * @component Login.vue
 * Formulaire de connexion utilisateur.
 *
 * Authentifie via Sanctum avec POST `/login` et gère la redirection.
 * Gère les erreurs, les notifications, et la validation du mot de passe.
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-100 dark:from-indigo-900 dark:to-blue-950 flex items-center justify-center px-4">
    <!-- Bouton de retour à l'accueil -->
    <div class="fixed top-5 left-5 z-50">
      <button @click="confirmReturnHome" class="px-4 py-2 bg-white dark:bg-gray-700 hover:bg-blue-200 dark:hover:bg-blue-800 text-gray-700 dark:text-white rounded-lg shadow flex items-center gap-2 transition-colors duration-200">
      <span>🏠</span>
    </button>
    </div>
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 space-y-6 transition-colors duration-200">
      <h2 class="text-2xl font-bold text-center text-blue-700 dark:text-blue-300">Connexion</h2>
      
      <!-- Formulaire de connexion -->
      <form @submit.prevent="submitLogin" class="space-y-4">
        <!-- Champ Email -->
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-500"
        />
        
        <!-- Champ Mot de passe -->
        <input
          v-model="password"
          type="password"
          placeholder="Mot de passe"
          required
          minlength="8"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-500"
        />
        
        <!-- Bouton de soumission -->
        <button
          type="submit"
          :disabled="isSubmitting"
          class="w-full py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition font-semibold disabled:opacity-50"
        >
          {{ isSubmitting ? 'Connexion en cours...' : 'Se connecter' }}
        </button>
      </form>
      
      <!-- Lien vers la page d'inscription -->
      <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
        <router-link to="/register" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:underline">
          🔼 Pas encore inscrit ? Créer un compte
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
// Imports Vue et bibliothèques externes
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

// Fonctions personnalisées
import { login, fetchUser } from '@/auth.js'
import { showNotification } from '@/stores/notificationStore'

// Données réactives
const email = ref('')
const password = ref('')
const isSubmitting = ref(false)
const router = useRouter()

/**
 * Fonction appelée lors de la soumission du formulaire.
 * Elle effectue une tentative de connexion avec Sanctum.
 */
const submitLogin = async () => {
  if (isSubmitting.value) return
  
  try {
    isSubmitting.value = true
    
    // Nécessaire avec Sanctum pour initialiser la session
    await axios.get('/sanctum/csrf-cookie')
    
    const response = await axios.post('/login', {
      email: email.value,
      password: password.value
    })
    
    if (response.status === 200) {
      await fetchUser() // Récupère l'utilisateur connecté
      
      // Affiche une notification de succès
      await showNotification({
        type: 'success',
        message: 'Connexion réussie ! Redirection...',
        duration: 2000
      })
      
      router.push('/testimonies') // Redirige vers les témoignages
    } else {
      throw new Error('Connexion échouée')
    }
  } catch (error) {
    // Gestion des erreurs
    const errorMessage = error.response?.data?.message
      || 'Impossible de se connecter. Vérifiez vos identifiants.'
      
    showNotification({
      type: 'error',
      title: 'Échec de connexion',
      message: errorMessage,
      duration: 0
    })
  } finally {
    isSubmitting.value = false
  }
}

/**
 * Confirme le retour à l'accueil
 */
 const confirmReturnHome = () => {
  showNotification({
    type: 'warning',
    title: 'Quitter la connexion',
    message: 'Voulez-vous retourner à l\'accueil ?',
    action: true,
    actionText: 'Quitter',
    position: 'top-4 inset-x-0 mx-auto'
  }).then(result => {
    if (result === 'action') {
      router.push('/');
    }
  });
};
</script>

<style scoped>
/* Animation de transition similaire à celle de Chapter.vue */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
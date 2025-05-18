<!--
/**
 * @component Register.vue
 * Formulaire d'inscription utilisateur.
 *
 * Crée un compte via POST `/register` et connecte automatiquement après succès.
 * Vérifie que les mots de passe correspondent.
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900 dark:to-indigo-950 flex items-center justify-center px-4">
    <!-- Bouton de retour à l'accueil -->
    <div class="fixed top-5 left-5 z-50">
      <button @click="confirmReturnHome" class="px-4 py-2 bg-white dark:bg-gray-700 hover:bg-blue-200 dark:hover:bg-blue-800 text-gray-700 dark:text-white rounded-lg shadow flex items-center gap-2 transition-colors duration-200">
      <span>🏠</span>
      </button>
    </div>
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 space-y-6 transition-colors duration-200">
      <h1 class="text-2xl font-bold text-center text-indigo-700 dark:text-indigo-300">Créer un compte</h1>

      <!-- Formulaire d'inscription -->
      <form @submit.prevent="submit" class="space-y-4">
        
        <!-- Champ Nom -->
        <input
          v-model="name"
          type="text"
          placeholder="Nom"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-500"
        />

        <!-- Champ Email -->
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-500"
        />

        <!-- Champ Mot de passe -->
        <input
          v-model="password"
          type="password"
          placeholder="Mot de passe"
          required
          minlength="8"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-500"
        />

        <!-- Confirmation du mot de passe -->
        <input
          v-model="password_confirmation"
          type="password"
          placeholder="Confirmer le mot de passe"
          required
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-indigo-500"
        />

        <!-- Bouton d'envoi -->
        <button
          type="submit"
          :disabled="isSubmitting"
          class="w-full py-2 bg-indigo-600 dark:bg-indigo-700 text-white rounded-lg hover:bg-indigo-700 dark:hover:bg-indigo-600 transition font-semibold disabled:opacity-50"
        >
          {{ isSubmitting ? 'Création en cours...' : 'Créer mon compte' }}
        </button>

        <!-- Avertissement manuel -->
        <p class="text-xs text-center text-gray-500 dark:text-gray-400 mt-2">
          ⚠️ Si la redirection vers les témoignages ne fonctionne pas, connectez-vous manuellement avec vos identifiants.
        </p>
      </form>

      <!-- Lien vers la page de connexion -->
      <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
        <router-link to="/login" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:underline">
          🔼 Retourner vers "Se connecter"
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
// Import des outils Vue
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

// Fonctions personnalisées
import { showNotification } from '@/stores/notificationStore'
import { fetchUser } from '@/auth'

// Données réactives du formulaire
const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const isSubmitting = ref(false)

const router = useRouter()

/**
 * Envoie les données d'inscription au backend.
 * Si les mots de passe ne correspondent pas, affiche une erreur immédiate.
 * Sinon, envoie la requête POST et redirige si succès.
 */
const submit = async () => {
  if (isSubmitting.value) return

  // Vérifie la correspondance des mots de passe
  if (password.value !== password_confirmation.value) {
    await showNotification({
      type: 'error',
      message: 'Les mots de passe ne correspondent pas',
      duration: 3000
    })
    return
  }

  try {
    isSubmitting.value = true

    await axios.get('/sanctum/csrf-cookie')

    const response = await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    })

    if ([200, 201, 204].includes(response.status)) {
      await fetchUser()
      await showNotification({
        type: 'success',
        message: 'Compte créé avec succès ! Redirection...',
        duration: 2000
      })
      router.push('/testimonies')
    } else {
      throw new Error('Inscription échouée')
    }
  } catch (error) {
    console.error("Erreur lors de l'inscription:", error)

    // Gestion fine des erreurs Laravel (validation, serveur, etc.)
    let errorMessage = 'Une erreur est survenue lors de la création du compte.'
    if (error.response?.data?.errors) {
      errorMessage = Object.values(error.response.data.errors).flat().join('\n')
    } else if (error.response?.data?.message) {
      errorMessage = error.response.data.message
    }

    await showNotification({
      type: 'error',
      title: "Erreur d'inscription",
      message: errorMessage,
      duration: 5000
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
/* Animation de transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
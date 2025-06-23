<template>
  <div class="max-w-3xl mx-auto px-4 py-10 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-200">

    <!-- Bouton retour accueil à gauche -->
    <div class="fixed top-5 left-5 z-50">
      <button
        @click="goHome"
        class="px-4 py-2 bg-white hover:bg-beige-100 dark:bg-gray-700 dark:hover:bg-gray-800 text-gray-800 dark:text-white rounded-lg shadow flex items-center gap-2 transition-colors duration-200"
      >
        <span>🏠</span>
      </button>
    </div>

    <!-- Titre -->
    <h1 class="text-4xl font-bold text-center mb-10 text-gray-800 dark:text-gray-100">
      Soumettre un témoignage
    </h1>

    <!-- Formulaire -->
    <form @submit.prevent="submitTestimony" class="space-y-6 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md transition-colors duration-200">
      <!-- Champ titre -->
      <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
        <input 
          v-model="form.title"
          type="text"
          id="title"
          :disabled="isSubmitting"
          required
          class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <p v-if="errors.title" class="text-sm text-red-500 mt-1">{{ errors.title[0] }}</p>
      </div>

      <!-- Champ contenu -->
      <div>
        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Témoignage</label>
        <textarea 
          v-model="form.content"
          id="content"
          rows="5"
          :disabled="isSubmitting"
          required
          class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>
        <p v-if="errors.content" class="text-sm text-red-500 mt-1">{{ errors.content[0] }}</p>
      </div>

      <!-- Bouton -->
      <button 
        type="submit"
        :disabled="isSubmitting || !isFormValid"
        class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded shadow transition duration-200"
      >
        {{ isSubmitting ? 'Envoi en cours...' : 'Soumettre le témoignage' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
  title: '',
  content: '',
})

const errors = ref({})
const isSubmitting = ref(false)

const isFormValid = computed(() =>
  form.value.title.trim() && form.value.content.trim()
)

const submitTestimony = async () => {
  if (!isFormValid.value) return

  isSubmitting.value = true
  errors.value = {}

  try {
    await axios.get('/sanctum/csrf-cookie')

    await axios.post('/testimonies', form.value)

    alert('Témoignage soumis avec succès!')
    resetForm()
    router.push('/testimonies')

  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors
    } else if (error.response?.status === 401) {
      router.push('/login')
    } else {
      console.error('Erreur soumission:', error)
      alert('Erreur lors de la soumission')
    }
  } finally {
    isSubmitting.value = false
  }
}

const resetForm = () => {
  form.value = { title: '', content: '' }
}

const goHome = () => {
  router.push('/testimonies')
}

onMounted(async () => {
  try {
    await axios.get('/api/user')
  } catch (error) {
    router.push('/login')
  }
})
</script>

<style scoped>
/* Optionnel : légère animation d’apparition */
form {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

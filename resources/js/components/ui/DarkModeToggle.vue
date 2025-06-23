<!--
/**
 * @component DarkModeToggle.vue
 * Bouton de bascule entre les modes clair et sombre pour l'application.
 *
 * Ce composant lit la préférence utilisateur depuis `localStorage` ou, si elle est absente, depuis les préférences système.
 * Il met à jour dynamiquement la classe `dark` sur l'élément `<html>` pour activer les styles correspondants (via Tailwind CSS).
 * L'état est réactif et persistant, même après un rechargement de page.
 *
 * @access public
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Juin 2025
 */
-->

<template>
  <!-- Bouton fixé dans l’interface pour activer/désactiver le dark mode -->
  <button
    @click="toggleDarkMode"
    class="fixed top-5 left-16 z-50 p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-xl transition-colors"
    aria-label="Basculer le mode sombre"
  >
    <!-- Affichage conditionnel de l’icône selon le mode -->
    <span v-if="isDarkMode">🌞</span>
    <span v-else>🌙</span>
  </button>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

/**
 * Indique si le mode sombre est activé.
 * @type {import('vue').Ref<boolean>}
 */
const isDarkMode = ref(false)

/**
 * Bascule entre les modes clair et sombre.
 * Met à jour `localStorage` et la classe `<html>`.
 */
const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value
  localStorage.setItem('darkMode', isDarkMode.value ? 'dark' : 'light')
  updateDocumentClass()
}

/**
 * Applique ou retire la classe `dark` sur `<html>` en fonction de `isDarkMode`.
 */
const updateDocumentClass = () => {
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
  } else {
    document.documentElement.classList.remove('dark')
  }
}

/**
 * Réagit aux changements de préférence système (`prefers-color-scheme`).
 * Utilisé uniquement si l'utilisateur n’a pas de préférence enregistrée.
 * 
 * @param {MediaQueryListEvent} e
 */
const handleSystemPreferenceChange = (e) => {
  if (localStorage.getItem('darkMode') === null) {
    isDarkMode.value = e.matches
    updateDocumentClass()
  }
}

// Initialisation à la création du composant
onMounted(() => {
  const savedMode = localStorage.getItem('darkMode')
  if (savedMode === 'dark') {
    isDarkMode.value = true
  } else if (savedMode === null) {
    isDarkMode.value = window.matchMedia('(prefers-color-scheme: dark)').matches
  }

  updateDocumentClass()

  // Ajout du listener système
  const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
  mediaQuery.addEventListener('change', handleSystemPreferenceChange)
})

// Nettoyage à la destruction du composant
onUnmounted(() => {
  const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
  mediaQuery.removeEventListener('change', handleSystemPreferenceChange)
})
</script>

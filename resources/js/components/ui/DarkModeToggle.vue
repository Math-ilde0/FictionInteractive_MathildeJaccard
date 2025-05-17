<template>
    <button
      @click="toggleDarkMode"
      class="fixed top-5 left-16 z-50 p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-xl transition-colors"
      aria-label="Toggle dark mode"
    >
      <span v-if="isDarkMode">🌞</span>
      <span v-else>🌙</span>
    </button>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from 'vue';
  
  const isDarkMode = ref(false);
  
  // Fonction pour basculer entre mode clair et sombre
  const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    localStorage.setItem('darkMode', isDarkMode.value ? 'dark' : 'light');
    updateDocumentClass();
  };
  
  // Met à jour la classe sur l'élément HTML
  const updateDocumentClass = () => {
    if (isDarkMode.value) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  };
  
  // Pour réagir aux changements de préférence du système
  const handleSystemPreferenceChange = (e) => {
    if (localStorage.getItem('darkMode') === null) {
      isDarkMode.value = e.matches;
      updateDocumentClass();
    }
  };
  
  // Initialise le mode depuis localStorage au chargement
  onMounted(() => {
    const savedMode = localStorage.getItem('darkMode');
    if (savedMode === 'dark') {
      isDarkMode.value = true;
    } else if (savedMode === null) {
      // Détection automatique des préférences du système
      isDarkMode.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    updateDocumentClass();
    
    // Ajouter l'écouteur pour les changements de préférence système
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.addEventListener('change', handleSystemPreferenceChange);
  });
  
  // Nettoyer l'écouteur lorsque le composant est démonté
  onUnmounted(() => {
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    mediaQuery.removeEventListener('change', handleSystemPreferenceChange);
  });
  </script>
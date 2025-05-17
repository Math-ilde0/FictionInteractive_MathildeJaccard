<!--
/**
 * @component App.vue
 * Composant racine de l’application Vue (SPA).
 *
 * Structure de base de l’application :
 * - Affiche les routes dynamiques via <router-view>
 * - Intègre les notifications globales
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->
<template>
  <!-- Conteneur principal de l'application avec style personnalisé -->
  <div
  class="font-[Dancing_Script] bg-[#f4f1e3] dark:bg-gray-900 text-[#333] dark:text-gray-200 leading-relaxed min-h-screen pt-10 overflow-y-auto transition-colors"
>
    <!-- Affiche dynamiquement les composants selon la route -->
    <router-view />

    <!-- Ajouter le toggle dark mode -->
    <DarkModeToggle />
    
    <!-- Conteneur global pour les notifications -->
    <NotificationContainer />
  </div>
</template>

<script>
// Import du composant centralisé des notifications
import NotificationContainer from './error/NotificationContainer.vue';
import DarkModeToggle from './ui/DarkModeToggle.vue';

export default {
  name: 'App',
  components: {
    NotificationContainer,
    DarkModeToggle
  }
};
</script>

<style>
/* Import de la police Merienda depuis Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap');

/* Animation d'apparition/disparition douce pour transitions */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

/* Transition globale des couleurs pour le mode sombre */
.transition-colors {
  transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}
</style>

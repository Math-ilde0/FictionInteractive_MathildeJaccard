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
    class="font-[Dancing_Script] bg-[#f4f1e3] text-[#333] leading-relaxed min-h-screen pt-10 overflow-y-auto"
  >
    <!-- Affiche dynamiquement les composants selon la route -->
    <router-view />

    <!-- Conteneur global pour les notifications -->
    <NotificationContainer />
  </div>
</template>

<script>
// Import du composant centralisé des notifications
import NotificationContainer from './error/NotificationContainer.vue';

export default {
  name: 'App',
  components: {
    NotificationContainer
  }
};
</script>

<style>
/* Import de la police Merienda depuis Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap');

/* Animation d’apparition/disparition douce pour transitions */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

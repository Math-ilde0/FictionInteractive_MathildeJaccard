<!--
/**
 * @component NotificationContainer.vue
 * Conteneur global qui affiche dynamiquement les notifications à l’écran.
 *
 * Reçoit les données depuis `notificationStore.js` (état global).
 * Sert à centraliser l’affichage des messages utilisateur dans toute l’app.
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <!-- Composant Notification rendu dynamiquement à partir du store -->
  <Notification
    :show="notification.show"
    :type="notification.type"
    :title="notification.title"
    :message="notification.message"
    :dismissible="true"
    :duration="notification.duration"
    :position="notification.position"
    :action="notification.action"
    :actionText="notification.actionText"
    @dismiss="hideNotification"
    @action="triggerAction"
  />
</template>

<script setup>
// Importation du composant Notification
import Notification from './notification.vue';

// Importation du store global pour contrôler l'état d'affichage
import { notification, hideNotification, triggerAction } from '@/stores/notificationStore';
</script>

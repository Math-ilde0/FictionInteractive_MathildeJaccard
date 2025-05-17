/**
 * @file notificationStore.js
 * @description
 * Store réactif Vue 3 pour gérer les notifications dans l'application.
 * Utilisé avec NotificationContainer.vue pour afficher des messages temporaires ou interactifs.
 * 
 * Fonctionnalités :
 * - Afficher une notification avec configuration personnalisée
 * - Attendre une action utilisateur (ex: clic sur un bouton)
 * - Masquer automatiquement ou manuellement la notification
 */

import { ref, reactive } from 'vue';

/**
 * État réactif contenant les propriétés d'une notification active.
 * Peut être utilisé directement dans un composant avec `v-if` ou `v-show`.
 */
const notification = reactive({
  show: false,           // Affiche ou non la notification
  type: 'info',          // Type visuel (info, warning, error, success)
  title: '',             // Titre affiché en gras
  message: '',           // Message principal
  action: false,         // Si un bouton d'action est présent
  actionText: 'Réessayer', // Texte du bouton d'action
  duration: 5000,        // Durée avant disparition auto (ms)
  position: 'bottom-4 right-4' // Position CSS de la notification
});

/**
 * Référence interne pour gérer les résolutions de promesse (action/fermeture).
 * Permet de réagir aux actions utilisateur.
 */
let notificationResolve = null;

/**
 * Affiche une notification avec options personnalisables.
 * Retourne une promesse résolue lors de l'action utilisateur ou de la fermeture.
 * @param {Object} options - Options pour personnaliser la notification
 * @returns {Promise<'action'|undefined>}
 */
const showNotification = (options) => {
  hideNotification(); // Réinitialise les éventuelles anciennes notifications

  // Applique les nouvelles options et rend visible
  Object.assign(notification, {
    show: true,
    ...options
  });

  // Permet au composant de "réagir" à une action utilisateur
  return new Promise((resolve) => {
    notificationResolve = resolve;
  });
};

/**
 * Masque la notification actuelle et résout la promesse (si présente).
 * Utilisé pour fermeture manuelle ou automatique.
 */
const hideNotification = () => {
  notification.show = false;
  if (notificationResolve) {
    notificationResolve();
    notificationResolve = null;
  }
};

/**
 * Déclenche une action utilisateur (ex: clic bouton) et résout la promesse.
 * Utilisé pour des confirmations ou interactions.
 */
const triggerAction = () => {
  if (notificationResolve) {
    notificationResolve('action');
    notificationResolve = null;
  }
  hideNotification();
};

// Exporte les méthodes et l’état réactif
export { notification, showNotification, hideNotification, triggerAction };

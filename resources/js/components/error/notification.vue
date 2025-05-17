<!--
/**
 * @component Notification.vue
 * Composant individuel d’une notification (succès, erreur, info, etc.).
 *
 * Affiche un message temporaire ou permanent, avec animation.
 * Peut contenir un bouton d’action (ex. “Réessayer”).
 *
 * Utilisé par NotificationContainer.
 *
 * @auteur Mathilde Jaccard – HEIG-VD
 * @date Mai 2025
 */
-->

<template>
  <!-- Affichage conditionnel avec animation -->
  <transition name="notify">
    <div
      v-if="show"
      :class="[
        'fixed z-50 p-4 rounded-lg shadow-lg max-w-md transition-all duration-300',
        position,
        notificationTypeClass
      ]"
      role="alert"
    >
      <!-- Contenu principal -->
      <div class="flex items-start">
        <!-- Icône contextuelle -->
        <div class="flex-shrink-0 mr-3 text-xl">
          <span v-if="type === 'error'">⚠️</span>
          <span v-else-if="type === 'success'">✅</span>
          <span v-else-if="type === 'warning'">⚡</span>
          <span v-else>ℹ️</span>
        </div>

        <!-- Texte de la notification -->
        <div class="flex-1">
          <p v-if="title" class="font-bold mb-1">{{ title }}</p>
          <p class="text-sm">{{ message }}</p>
        </div>

        <!-- Bouton de fermeture -->
        <button
          v-if="dismissible"
          @click="dismiss"
          class="ml-2 text-gray-500 hover:text-gray-700"
          aria-label="Fermer"
        >
          ×
        </button>
      </div>

      <!-- Bouton d'action facultatif -->
      <div v-if="action" class="mt-2 text-right">
        <button
          @click="onAction"
          class="px-3 py-1 text-sm font-medium rounded-md"
          :class="notificationButtonClass"
        >
          {{ actionText }}
        </button>
      </div>
    </div>
  </transition>
</template>

<script setup>
// Importation des fonctions de Vue
import { computed, onMounted, onUnmounted, watch } from 'vue';

// Props du composant
const props = defineProps({
  show: { type: Boolean, default: false },
  type: {
    type: String,
    default: 'info',
    validator: val => ['info', 'success', 'error', 'warning'].includes(val)
  },
  title: { type: String, default: '' },
  message: { type: String, required: true },
  dismissible: { type: Boolean, default: true },
  duration: { type: Number, default: 5000 },
  position: {
    type: String,
    default: 'bottom-4 right-4',
    validator: val => [
      'top-4 right-4', 'top-4 left-4',
      'bottom-4 right-4', 'bottom-4 left-4',
      'top-4 inset-x-0 mx-auto', 'bottom-4 inset-x-0 mx-auto'
    ].includes(val)
  },
  action: { type: Boolean, default: false },
  actionText: { type: String, default: 'Réessayer' }
});

// Événements émis
const emit = defineEmits(['dismiss', 'action']);

let timer = null;

// Détermine les classes selon le type de notification
const notificationTypeClass = computed(() => {
  switch (props.type) {
    case 'error': return 'bg-red-100 border-l-4 border-red-500 text-red-700';
    case 'success': return 'bg-green-100 border-l-4 border-green-500 text-green-700';
    case 'warning': return 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700';
    default: return 'bg-blue-100 border-l-4 border-blue-500 text-blue-700';
  }
});

// Détermine le style du bouton d'action
const notificationButtonClass = computed(() => {
  switch (props.type) {
    case 'error': return 'bg-red-500 text-white hover:bg-red-600';
    case 'success': return 'bg-green-500 text-white hover:bg-green-600';
    case 'warning': return 'bg-yellow-500 text-white hover:bg-yellow-600';
    default: return 'bg-blue-500 text-white hover:bg-blue-600';
  }
});

// Ferme la notification manuellement
const dismiss = () => emit('dismiss');

// Gère l'action personnalisée
const onAction = () => emit('action');

// Lance un timer pour fermer automatiquement la notification
const startTimer = () => {
  if (props.duration > 0 && props.dismissible) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      dismiss();
    }, props.duration);
  }
};

// Lance le timer si `show` passe à true
watch(() => props.show, (newValue) => {
  if (newValue) startTimer();
  else clearTimeout(timer);
});

// Lance le timer à l'affichage du composant
onMounted(() => {
  if (props.show) startTimer();
});

// Nettoyage du timer lors du démontage
onUnmounted(() => clearTimeout(timer));
</script>

<style scoped>
/* Animation d'apparition/disparition */
.notify-enter-active,
.notify-leave-active {
  transition: all 0.3s ease;
}
.notify-enter-from,
.notify-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
</style>

<!-- resources/js/components/ui/Notification.vue -->
<template>
  <!-- Notification avec animation d'apparition/disparition -->
  <transition name="notify">
    <!-- Boîte de notification visible uniquement si `show` est true -->
    <div 
      v-if="show" 
      :class="[
        'fixed z-50 p-4 rounded-lg shadow-lg max-w-md transition-all duration-300',
        position,
        typeClasses
      ]"
    >
      <!-- Contenu principal de la notification -->
      <div class="flex items-start">
        <!-- Icône selon le type de notification -->
        <div class="flex-shrink-0 mr-3">
          <span v-if="type === 'error'" class="text-xl">⚠️</span>
          <span v-else-if="type === 'success'" class="text-xl">✅</span>
          <span v-else-if="type === 'warning'" class="text-xl">⚡</span>
          <span v-else class="text-xl">ℹ️</span>
        </div>

        <!-- Texte de la notification -->
        <div class="flex-1">
          <p v-if="title" class="font-bold mb-1">{{ title }}</p>
          <p class="text-sm">{{ message }}</p>
        </div>

        <!-- Bouton pour fermer la notification -->
        <button 
          v-if="dismissible" 
          @click="dismiss" 
          class="ml-2 text-gray-500 hover:text-gray-700"
          aria-label="Fermer"
        >
          ×
        </button>
      </div>

      <!-- Bouton d’action facultatif -->
      <div v-if="action" class="mt-2 text-right">
        <button 
          @click="onAction" 
          class="px-3 py-1 text-sm font-medium rounded-md"
          :class="actionButtonClass"
        >
          {{ actionText }}
        </button>
      </div>
    </div>
  </transition>
</template>
<script setup>
// Import des fonctions de Vue
import { computed, onMounted, onUnmounted, watch } from 'vue';

// Définition des props attendues
const props = defineProps({
  show: { type: Boolean, default: false },
  type: { type: String, default: 'info', validator: val => ['info', 'success', 'error', 'warning'].includes(val) },
  title: { type: String, default: '' },
  message: { type: String, required: true },
  dismissible: { type: Boolean, default: true },
  duration: { type: Number, default: 5000 }, // Durée avant disparition auto (ms)
  position: {
    type: String,
    default: 'bottom-4 right-4',
    validator: val => [
      'top-4 right-4', 'top-4 left-4',
      'bottom-4 right-4', 'bottom-4 left-4',
      'top-4 inset-x-0 mx-auto', 'bottom-4 inset-x-0 mx-auto'
    ].includes(val)
  },
  action: { type: Boolean, default: false },        // Si un bouton d’action est visible
  actionText: { type: String, default: 'Réessayer' } // Texte du bouton d’action
});

// Définition des événements personnalisés
const emit = defineEmits(['dismiss', 'action']);

// Timer pour la fermeture automatique
let timer = null;

// Couleurs selon le type de notification
const typeClasses = computed(() => {
  switch (props.type) {
    case 'error': return 'bg-red-100 border-l-4 border-red-500 text-red-700';
    case 'success': return 'bg-green-100 border-l-4 border-green-500 text-green-700';
    case 'warning': return 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700';
    default: return 'bg-blue-100 border-l-4 border-blue-500 text-blue-700';
  }
});

// Styles du bouton d’action
const actionButtonClass = computed(() => {
  switch (props.type) {
    case 'error': return 'bg-red-500 text-white hover:bg-red-600';
    case 'success': return 'bg-green-500 text-white hover:bg-green-600';
    case 'warning': return 'bg-yellow-500 text-white hover:bg-yellow-600';
    default: return 'bg-blue-500 text-white hover:bg-blue-600';
  }
});

// Méthode appelée pour fermer la notification
const dismiss = () => emit('dismiss');

// Méthode appelée si le bouton d’action est cliqué
const onAction = () => emit('action');

// Démarrer un timer pour fermer automatiquement après `duration`
const startTimer = () => {
  if (props.duration > 0 && props.dismissible) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      dismiss();
    }, props.duration);
  }
};

// Regarder les changements de visibilité
watch(() => props.show, (newValue) => {
  if (newValue) startTimer();
  else clearTimeout(timer);
});

// Lancer le timer à l’affichage du composant
onMounted(() => {
  if (props.show) startTimer();
});

// Nettoyage du timer en démontage
onUnmounted(() => clearTimeout(timer));
</script>

<style scoped>
/* Animation d’entrée/sortie de la notification */
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

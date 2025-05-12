<!-- resources/js/components/ui/Notification.vue -->
<template>
    <transition name="notify">
      <div 
        v-if="show" 
        :class="[
          'fixed z-50 p-4 rounded-lg shadow-lg max-w-md transition-all duration-300',
          position,
          typeClasses
        ]"
      >
        <div class="flex items-start">
          <div class="flex-shrink-0 mr-3">
            <span v-if="type === 'error'" class="text-xl">⚠️</span>
            <span v-else-if="type === 'success'" class="text-xl">✅</span>
            <span v-else-if="type === 'warning'" class="text-xl">⚡</span>
            <span v-else class="text-xl">ℹ️</span>
          </div>
          <div class="flex-1">
            <p v-if="title" class="font-bold mb-1">{{ title }}</p>
            <p class="text-sm">{{ message }}</p>
          </div>
          <button 
            v-if="dismissible" 
            @click="dismiss" 
            class="ml-2 text-gray-500 hover:text-gray-700"
            aria-label="Fermer"
          >
            ×
          </button>
        </div>
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
  import { computed, onMounted, onUnmounted, watch } from 'vue';
  
  const props = defineProps({
    show: {
      type: Boolean,
      default: false
    },
    type: {
      type: String,
      default: 'info',
      validator: (value) => ['info', 'success', 'error', 'warning'].includes(value)
    },
    title: {
      type: String,
      default: ''
    },
    message: {
      type: String,
      required: true
    },
    dismissible: {
      type: Boolean,
      default: true
    },
    duration: {
      type: Number,
      default: 5000 // 5 secondes par défaut
    },
    position: {
      type: String,
      default: 'bottom-4 right-4',
      validator: (value) => [
        'top-4 right-4', 'top-4 left-4', 
        'bottom-4 right-4', 'bottom-4 left-4',
        'top-4 inset-x-0 mx-auto', 'bottom-4 inset-x-0 mx-auto'
      ].includes(value)
    },
    action: {
      type: Boolean,
      default: false
    },
    actionText: {
      type: String,
      default: 'Réessayer'
    }
  });
  
  const emit = defineEmits(['dismiss', 'action']);
  
  let timer = null;
  
  const typeClasses = computed(() => {
    switch (props.type) {
      case 'error':
        return 'bg-red-100 border-l-4 border-red-500 text-red-700';
      case 'success':
        return 'bg-green-100 border-l-4 border-green-500 text-green-700';
      case 'warning':
        return 'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700';
      default:
        return 'bg-blue-100 border-l-4 border-blue-500 text-blue-700';
    }
  });
  
  const actionButtonClass = computed(() => {
    switch (props.type) {
      case 'error':
        return 'bg-red-500 text-white hover:bg-red-600';
      case 'success':
        return 'bg-green-500 text-white hover:bg-green-600';
      case 'warning':
        return 'bg-yellow-500 text-white hover:bg-yellow-600';
      default:
        return 'bg-blue-500 text-white hover:bg-blue-600';
    }
  });
  
  const dismiss = () => {
    emit('dismiss');
  };
  
  const onAction = () => {
    emit('action');
  };
  
  const startTimer = () => {
    if (props.duration > 0 && props.dismissible) {
      clearTimeout(timer);
      timer = setTimeout(() => {
        dismiss();
      }, props.duration);
    }
  };
  
  watch(() => props.show, (newValue) => {
    if (newValue) {
      startTimer();
    } else {
      clearTimeout(timer);
    }
  });
  
  onMounted(() => {
    if (props.show) {
      startTimer();
    }
  });
  
  onUnmounted(() => {
    clearTimeout(timer);
  });
  </script>
  
  <style scoped>
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
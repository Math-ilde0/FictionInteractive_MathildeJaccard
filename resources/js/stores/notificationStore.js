// resources/js/stores/notificationStore.js
import { ref, reactive } from 'vue';

// État initial
const notification = reactive({
  show: false,
  type: 'info',
  title: '',
  message: '',
  action: false,
  actionText: 'Réessayer',
  duration: 5000,
  position: 'bottom-4 right-4'
});

// Actions
const showNotification = (options) => {
  // Reset to default values first
  hideNotification();
  
  // Then apply new options
  Object.assign(notification, {
    show: true,
    ...options
  });
  
  // Return a promise that resolves when the notification is dismissed
  return new Promise((resolve) => {
    notificationResolve = resolve;
  });
};

const hideNotification = () => {
  notification.show = false;
  if (notificationResolve) {
    notificationResolve();
    notificationResolve = null;
  }
};

const triggerAction = () => {
  if (notificationResolve) {
    notificationResolve('action');
    notificationResolve = null;
  }
  hideNotification();
};

// Used for promise resolution
let notificationResolve = null;

export { notification, showNotification, hideNotification, triggerAction };
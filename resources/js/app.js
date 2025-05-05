import { createApp } from 'vue';
import App from './components/App.vue';  // Le composant App qui contient les routes
import router from './router';  // Le routeur

const app = createApp(App);  // Crée l'instance de l'application Vue
app.use(router);  // Utilise Vue Router pour la navigation
app.mount('#app');  // Monte Vue.js dans l'élément avec l'ID `app`

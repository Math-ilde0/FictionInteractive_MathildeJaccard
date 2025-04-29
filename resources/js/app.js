import '../css/app.css';
import './bootstrap';

import { createApp } from 'vue';
import router from './router'; // Ton fichier router.js
import App from './components/App.vue';

// Créer l'application Vue et utiliser Vue Router
const app = createApp(App);

app.use(router);

app.mount('#app');

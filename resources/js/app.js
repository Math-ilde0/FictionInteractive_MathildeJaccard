/**
 * @file app.js
 * @description
 * Fichier d’entrée principal de l’application Vue.js.
 * Il importe les styles, initialise le routeur, et monte le composant racine `<App />`.
 * Ce fichier est souvent inclus dans `resources/js` dans un projet Laravel avec Vite.
 *
 * @auteur Mathilde Jaccard – HEIG-VD, Bachelor Media Engineering
 * @date Mai 2025
 */

import '../css/app.css'; // Import des styles globaux
import './bootstrap';    // Initialisation des dépendances (ex: Axios, CSRF)

// Vue core
import { createApp } from 'vue';

// Composants et routing
import router from './router';         // Fichier définissant les routes
import App from './components/App.vue'; // Composant racine

// Crée l'application Vue, attache le router, et la monte sur l'élément HTML #app
const app = createApp(App);
app.use(router);
app.mount('#app');

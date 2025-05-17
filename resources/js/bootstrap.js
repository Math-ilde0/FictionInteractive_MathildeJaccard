/**
 * @file bootstrap.js
 * @description
 * Configuration de base pour Axios dans une application Laravel + Vue.
 * Ce fichier définit les en-têtes par défaut pour les requêtes HTTP,
 * active l'envoi des cookies (`withCredentials`) et injecte le token CSRF.
 *
 * À inclure avant toute utilisation d’Axios pour sécuriser les appels vers l’API Laravel.
 *
 * @auteur Mathilde Jaccard – HEIG-VD, Bachelor Media Engineering
 * @date Mai 2025
 */

import axios from 'axios';

// Définir Axios globalement (optionnel mais courant dans les apps Vue/Laravel)
window.axios = axios;

// Définir les en-têtes standards pour toutes les requêtes Axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.withCredentials = true;

// Récupérer le token CSRF depuis la balise <meta name="csrf-token">
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

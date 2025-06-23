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
import router from './router'; 

// Définir Axios globalement (optionnel mais courant dans les apps Vue/Laravel)
window.axios = axios;

// Configuration Sanctum SPA
axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Intercepteur pour gestion des erreurs
axios.interceptors.response.use(
  response => response,
  async error => {
    if (error.response?.status === 419) {
      // Token CSRF expiré - renouveler
      await axios.get('/sanctum/csrf-cookie')
      return axios.request(error.config)
    }
    
    if (error.response?.status === 401) {
      // Non authentifié
      router.push('/login')
    }
    
    return Promise.reject(error)
  }
)
// Récupérer le token CSRF depuis la balise <meta name="csrf-token">
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

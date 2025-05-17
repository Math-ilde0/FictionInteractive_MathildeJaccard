/**
 * @file auth.js
 * @description
 * Ce module gère l’état d’authentification de l’utilisateur dans l’application Vue.
 * Il fournit les fonctions `login`, `logout`, et `fetchUser` pour interagir avec l’API Laravel protégée par Sanctum.
 * 
 * @fonctionnalités :
 * - Connexion de l’utilisateur (via `/login` + CSRF)
 * - Récupération du profil connecté (via `/api/user`)
 * - Déconnexion (via `/logout`)
 * - Suivi réactif de l’état d’authentification (`isAuthenticated`)
 *
 * @auteur Mathilde Jaccard – HEIG-VD, Bachelor Media Engineering
 * @date Mai 2025
 */

import { ref, computed } from 'vue';
import axios from 'axios';

// État utilisateur courant
const user = ref(null);

/**
 * Renvoie true si un utilisateur est connecté
 * @type {import('vue').ComputedRef<boolean>}
 */
const isAuthenticated = computed(() => !!user.value);

/**
 * Récupère les données de l’utilisateur connecté depuis l’API Laravel
 * @returns {Promise<Object|null>} L'utilisateur ou null s'il n'est pas connecté
 */
async function fetchUser() {
  try {
    const response = await axios.get('/api/user', {
      withCredentials: true,
      headers: {
        'Accept': 'application/json'
      }
    });
    user.value = response.data;
    return user.value;
  } catch (error) {
    user.value = null;
    console.error('Failed to fetch user:', error);
    return null;
  }
}

// Initialisation automatique à l'import
fetchUser();

/**
 * Tente de connecter l'utilisateur avec les identifiants fournis
 * @param {Object} credentials - Les identifiants { email, password }
 * @returns {Promise<boolean>} True si la connexion est réussie, false sinon
 */
async function login(credentials) {
  try {
    console.log('Démarrage processus de connexion');
    
    // Étape 1 : récupérer le cookie CSRF
    await axios.get('/sanctum/csrf-cookie');
    console.log('CSRF cookie obtenu');
    
    // Étape 2 : injecter le token CSRF si disponible
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    if (token) {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }
    
    // Étape 3 : envoi de la requête de connexion
    const response = await axios.post('/login', credentials, {
      withCredentials: true,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });

    // Étape 4 : récupération du profil utilisateur
    await fetchUser();
    return !!user.value;
  } catch (error) {
    console.error('Erreur de connexion :', error.response?.data || error);
    user.value = null;
    return false;
  }
}

/**
 * Déconnecte l'utilisateur en appelant l'API Laravel
 * @returns {Promise<boolean>} True si la déconnexion est réussie
 */
async function logout() {
  try {
    await axios.post('/logout', {}, {
      withCredentials: true,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    user.value = null;
    return true;
  } catch (error) {
    console.error('Logout failed:', error);
    user.value = null;
    return false;
  }
}

export { user, isAuthenticated, fetchUser, login, logout };

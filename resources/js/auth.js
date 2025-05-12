// resources/js/auth.js
import { ref, computed } from 'vue';
import axios from 'axios';

const user = ref(null);
const isAuthenticated = computed(() => !!user.value);

// Get the current user
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

// Try to fetch the user when the app loads
fetchUser();

// Login function
async function login(credentials) {
  try {
    console.log('Démarrage processus de connexion');
    
    // 1. Obtenir le cookie CSRF
    await axios.get('/sanctum/csrf-cookie');
    console.log('CSRF cookie obtenu');
    
    // 2. Vérifier l'en-tête CSRF
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    console.log('CSRF token trouvé:', !!token);
    
    if (token) {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }
    
    // 3. Tenter la connexion
    console.log('Envoi requête de connexion');
    const response = await axios.post('/login', credentials, {
      withCredentials: true,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    });
    console.log('Réponse reçue:', response.status);
    
    // 4. Récupérer les informations utilisateur
    await fetchUser();
    console.log('Utilisateur récupéré:', user.value);
    
    return !!user.value;
  } catch (error) {
    console.error('Détails de l\'erreur:', error.response?.data || error);
    user.value = null;
    return false;
  }
}

// Logout function
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
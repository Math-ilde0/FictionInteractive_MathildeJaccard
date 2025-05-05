import { ref, computed } from 'vue';
import axios from 'axios';

// Données de l'utilisateur
const user = ref(null);

// Récupérer l'utilisateur connecté
export async function fetchUser() {
    try {
      const response = await axios.get('/api/user');
      user.value = response.data;
    } catch (error) {
      user.value = null;
      console.error('Failed to fetch user', error);
    }
  }

// Vérifie si l'utilisateur est connecté
export const isAuthenticated = computed(() => !!user.value);

// Action de connexion
export async function login(credentials) {
    try {
      await axios.get('/sanctum/csrf-cookie'); // Important pour Sanctum
      await axios.post('/login', {
        email: credentials.email,
        password: credentials.password
      });
      await fetchUser();
      return true;
    } catch (error) {
      console.error('Erreur de connexion:', error.response?.data?.message || error.message);
      return false;
    }
  }
  

// Action de déconnexion
export async function logout() {
  try {
    await axios.post('/logout');
    user.value = null;
    window.location.href = '/'; // Rediriger après déconnexion
  } catch (error) {
    console.error('Erreur lors de la déconnexion:', error);
  }
}

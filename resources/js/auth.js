// resources/js/auth.js
import { ref, computed } from 'vue';
import axios from 'axios';

const user = ref(null);
const isAuthenticated = computed(() => !!user.value);

// Get the current user
async function fetchUser() {
  try {
    const response = await axios.get('/user');
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
      // Get CSRF cookie first
      await axios.get('/sanctum/csrf-cookie');
      
      // Add delay to ensure cookie is set
      await new Promise(resolve => setTimeout(resolve, 100));
      
      // Manually set CSRF token from meta tag as fallback
      const token = document.head.querySelector('meta[name="csrf-token"]')?.content;
      if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
      }
      
      // Attempt login with the CSRF token
      const response = await axios.post('/login', credentials);
      
      // Fetch the authenticated user
      await fetchUser();
      return true;
    } catch (error) {
      console.error('Login failed:', error.response || error);
      user.value = null;
      return false;
    }
  }
// Logout function
async function logout() {
  try {
    await axios.post('/logout');
    user.value = null;
    return true;
  } catch (error) {
    console.error('Logout failed:', error);
    user.value = null;
    return false;
  }
}

export { user, isAuthenticated, fetchUser, login, logout };
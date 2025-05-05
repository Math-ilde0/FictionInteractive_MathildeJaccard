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
        // Get CSRF cookie
        await axios.get('/sanctum/csrf-cookie');
        
        // Attempt login
        const response = await axios.post('/login', credentials);
        
        // Fetch the authenticated user
        await fetchUser();
        
        return true;
    } catch (error) {
        console.error('Login failed:', error.response?.data?.message || error.message);
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
        return false;
    }
}

export { user, isAuthenticated, fetchUser, login, logout };
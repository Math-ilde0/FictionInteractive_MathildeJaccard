import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = '/'; // Enlever le préfixe /api
window.axios.defaults.withCredentials = true;
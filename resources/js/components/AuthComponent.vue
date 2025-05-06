<script setup>
import { ref, computed } from 'vue';
import { user, logout } from '/resources/js/auth.js';
import { useRouter } from 'vue-router';

const router = useRouter();
const isAuthenticated = computed(() => !!user.value);

async function handleLogout() {
  const success = await logout();
  if (success) {
    router.push('/login');
  }
}
</script>

<template>
  <div class="fixed top-5 right-5 z-50">
    <button
      v-if="isAuthenticated"
      @click="handleLogout"
      class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow"
    >
      Se déconnecter
    </button>
    <router-link
      v-else
      to="/login"
      class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow"
    >
      Se connecter
    </router-link>
  </div>
</template>
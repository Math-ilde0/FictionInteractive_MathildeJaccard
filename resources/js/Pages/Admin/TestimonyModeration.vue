<template>
    <div class="max-w-5xl mx-auto p-6">
      <h1 class="text-3xl font-bold mb-6">Modération des témoignages</h1>
  
      <div v-if="loading" class="text-center text-gray-500">Chargement...</div>
      <div v-else-if="error" class="text-center text-red-500">{{ error }}</div>
  
      <div v-else>
        <div v-if="testimonies.length === 0" class="text-center text-gray-500">Aucun témoignage à valider.</div>
  
        <div v-for="testimony in testimonies" :key="testimony.id" class="p-4 mb-4 bg-white shadow rounded">
          <p class="text-gray-700 mb-2">{{ testimony.content }}</p>
          <div class="flex gap-4">
            <button @click="approveTestimony(testimony.id)" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
              ✅ Valider
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const testimonies = ref([]);
  const loading = ref(true);
  const error = ref(null);
  
  const loadPending = async () => {
    try {
      const res = await axios.get('/admin/testimonies/pending');
      testimonies.value = res.data;
    } catch (err) {
      error.value = 'Erreur de chargement';
    } finally {
      loading.value = false;
    }
  };
  
  const approveTestimony = async (id) => {
    try {
      await axios.patch(`/admin/testimonies/${id}/approve`);
      testimonies.value = testimonies.value.filter(t => t.id !== id);
    } catch (err) {
      console.error(err);
    }
  };
  
  onMounted(loadPending);
  </script>
  
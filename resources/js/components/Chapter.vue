<template>
  <main>
    <div class="book-page">
      <h1>Chapitre {{ chapter?.chapter_number || '?' }}</h1>
      <p>{{ chapter?.content }}</p>
      <ul class="choice-list">
        <li v-for="choice in choices" :key="choice.id">
          <button @click="goToChapter(choice.next_chapter_id)">
            {{ choice.text }}
          </button>
        </li>
      </ul>
    </div>
  </main>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const chapter = ref({});
const choices = ref([]);
const stressLevel = ref(0);
const route = useRoute();
const router = useRouter();

// Function to fetch chapter data based on the storyId and chapterId
const fetchChapter = async () => {
  const { storyId, chapterId } = route.params;
  console.log('Fetching chapter data for story:', storyId, 'chapter:', chapterId);
  
  try {
    // Ajoutez le préfixe '/api/' à l'URL
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    console.log('Chapter response:', response.data);
    chapter.value = response.data;
    choices.value = response.data.choices;
  } catch (error) {
    console.error('Erreur de chargement du chapitre:', error);
  }
};

// Function to navigate to the next chapter based on the choice selected
const goToChapter = (chapterId) => {
  console.log('Navigating to chapter:', chapterId);
  
  if (chapterId === null) {
    console.log('End of story, going to result page');
    // Si chapterId est null, rediriger vers la page de résultat
    const outcome = stressLevel.value >= 10 ? 'failure' : 'success';
    window.location.href = `/result/${outcome}`;
  } else {
    console.log(`Navigating to /story/${route.params.storyId}/chapter/${chapterId}`);
    // Utiliser window.location pour une navigation complète qui forcera le rechargement
    window.location.href = `/story/${route.params.storyId}/chapter/${chapterId}`;
  }
};

// Surveiller les changements de route pour recharger les données du chapitre
watch(
  () => route.params,
  (newParams, oldParams) => {
    console.log('Route params changed from', oldParams, 'to', newParams);
    if (newParams.chapterId !== oldParams.chapterId) {
      fetchChapter();
    }
  },
  { deep: true }
);

// Fetch chapter data when the component is mounted
onMounted(fetchChapter);
</script>

<style scoped>
.book-page {
  background-color: transparent;
  max-width: 700px;
  margin: 0 auto;
  padding: 60px 40px;
  border-radius: 8px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.book-page h1 {
  text-align: center;
  font-size: 2rem;
  margin-bottom: 20px;
}

.book-page p {
  font-size: 1.1rem;
  text-align: justify;
  letter-spacing: 0.5px;
  line-height: 1.8;
  margin-bottom: 2em;
}

.choice-list {
  list-style-type: none;
  padding: 0;
}

.choice-list li {
  margin: 15px 0;
}

.choice-list button {
  width: 100%;
  padding: 12px 20px;
  font-size: 1.1rem;
  background-color: #a5d6a7;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.choice-list button:hover {
  background-color: #81c784;
}
</style>
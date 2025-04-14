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
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const chapter = ref({});
const choices = ref([]);
const stressLevel = ref(0);
const route = useRoute();
const router = useRouter();

// Function to fetch chapter data based on the storyId and chapterId
const fetchChapter = async () => {
  const { storyId, chapterId } = route.params;  // Extract storyId and chapterId from the route parameters
  console.log('storyId:', storyId); // Check the storyId in the console
  console.log('chapterId:', chapterId); // Check the chapterId in the console
  
  try {
    // Fetch the chapter data from the API using the provided route
    const response = await axios.get(`/api/story/${storyId}/chapter/${chapterId}`);
    console.log('Chapter response:', response.data); // Log the chapter data returned by the API
    chapter.value = response.data; // Set the chapter data to the ref
    choices.value = response.data.choices; // Set the choices for the chapter
  } catch (error) {
    console.error('Erreur de chargement du chapitre:', error); // Log any error during the chapter data fetch
  }
};

// Function to navigate to the next chapter based on the choice selected
const goToChapter = (chapterId) => {
  if (chapterId === null) {
    // If chapterId is null, go to the result page based on stressLevel
    if (stressLevel.value >= 10) {
      router.push(`/result/failure`);
    } else {
      router.push(`/result/success`);
    }
  } else {
    // Navigate to the next chapter
    router.push(`/story/${route.params.storyId}/chapter/${chapterId}`);
  }
};

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

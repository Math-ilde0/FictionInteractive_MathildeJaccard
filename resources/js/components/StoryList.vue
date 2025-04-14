<template>
  <main>
    <div class="book-page">
      <h1 v-if="story">{{ story.title }}</h1>

      <!-- Display the summary of the story -->
      <p v-if="story && !loading">{{ story.summary }}</p>

      <!-- Display loading text while the story is being fetched -->
      <p v-if="loading">Chargement de l'histoire...</p>

      <!-- Show error message if no story is found -->
      <p v-else-if="!story && !loading">Aucune histoire trouvée.</p>

      <!-- Show the button to start the story -->
      <button v-if="story && !loading" @click="startStory">Démarrer l'histoire</button>
    </div>
  </main>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      story: null,  // Holds the story data
      loading: true,  // Tracks loading state
    };
  },
  mounted() {
    const storyId = 2;  // Hardcoded to match the seeded story
    // Note the updated URL to match the API route
    axios.get(`/api/story/${storyId}`)
      .then(response => {
        this.story = response.data;  // Set the story data
        this.loading = false;  // Data is loaded, stop loading
      })
      .catch(error => {
        console.error('Error loading story:', error);
        this.loading = false;  // Stop loading in case of an error
      });
  },
  methods: {
    // Method to start the story
    startStory() {
      // You can define what happens when the user starts the story (e.g., redirect to the first chapter)
      this.$router.push(`/story/${this.story.id}/chapter/1`); // Example: Redirecting to the first chapter
    }
  }
};
</script>

<style scoped>
.book-page {
  background-color: white;
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
  margin-bottom: 1.5em;
}

button {
  display: block;
  width: 100%;
  padding: 12px 20px;
  font-size: 1.1rem;
  background-color: #a5d6a7;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 20px;
}

button:hover {
  background-color: #81c784;
}
</style>
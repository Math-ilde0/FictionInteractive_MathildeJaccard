<template>
  <main>
    <div class="book-page">
      <h1>Choisissez une histoire</h1>

      <!-- Display loading text while stories are being fetched -->
      <p v-if="loading">Chargement des histoires...</p>

      <!-- Show error message if no stories are found -->
      <p v-else-if="stories.length === 0">Aucune histoire disponible.</p>

      <!-- List of stories -->
      <div v-else class="stories-list">
        <div 
          v-for="story in stories" 
          :key="story.id" 
          class="story-item"
        >
          <h2>{{ story.title }}</h2>
          <p>{{ story.summary }}</p>
          <button @click="startStory(story.id)">
            Commencer cette histoire
          </button>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      stories: [],  // Holds the list of stories
      loading: true,  // Tracks loading state
    };
  },
  mounted() {
    // Fetch all available stories
    axios.get('/api/stories')
      .then(response => {
        this.stories = response.data;  // Set the stories data
        this.loading = false;  // Data is loaded, stop loading
      })
      .catch(error => {
        console.error('Error loading stories:', error);
        this.loading = false;  // Stop loading in case of an error
      });
  },
  methods: {
    // Method to start a specific story
    startStory(storyId) {
      // Navigate to the first chapter of the selected story
      this.$router.push(`/story/${storyId}/chapter/1`);
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

.stories-list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.story-item {
  border: 1px solid #e0e0e0;
  padding: 20px;
  border-radius: 8px;
}

.story-item h2 {
  margin-top: 0;
  color: #333;
}

.story-item p {
  color: #666;
  margin-bottom: 15px;
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
}

button:hover {
  background-color: #81c784;
}
</style>
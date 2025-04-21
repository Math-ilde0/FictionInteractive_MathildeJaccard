import { createRouter, createWebHistory } from 'vue-router';
import StoryList from './components/StoryList.vue';
import Chapter from './components/Chapter.vue';
import Result from './components/Result.vue';

const routes = [
  {
    path: '/',
    component: StoryList,
  },
  {
    path: '/stories',
    name: 'StoryList',
    component: StoryList,
  },
  
  {
    path: '/story/:storyId/chapter/:chapterId',
    component: Chapter,
  },
  {
    path: '/result/:outcome',
    component: Result,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});



export default router;

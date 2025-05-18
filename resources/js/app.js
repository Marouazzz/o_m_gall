/**
 * Load dependencies
 */
import './bootstrap';
import { createApp } from 'vue';

/**
 * Import and register the Vue component
 */
import FollowButton from './components/FollowButton.vue';

/**
 * Create Vue application
 */
const app = createApp({});

/**
 * Register the component globally
 */
app.component('follow-button', FollowButton);

/**
 * Mount the Vue app
 */
app.mount('#app');

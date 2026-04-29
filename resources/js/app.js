import '../css/app.css';
import './icons.js';
import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {initTheme} from './composables/useTheme';
import {ZiggyVue} from 'ziggy-js';
import axios from 'axios';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

initTheme();

createInertiaApp({
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({el, App, props, plugin}) {
    createApp({render: () => h(App, props)})
      .use(plugin)
      .use(ZiggyVue)
      .component('font-awesome-icon', FontAwesomeIcon)
      .mount(el);
  },
  progress: {
    color: '#479cf8',
  },
}).then(_ => {
});

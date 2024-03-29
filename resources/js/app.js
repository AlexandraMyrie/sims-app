import { createPinia } from 'pinia';
import { useMainStore } from '@/stores/main';

import { darkModeKey, styleKey } from '@/config.js';

import { createApp, h } from 'vue';
import mdiVue from 'mdi-vue/v3';
import * as mdijs from '@mdi/js';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import FlashMessage from '@smartweb/vue-flash-message';
const pinia = createPinia();

const appName =
  window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
  icons: mdijs,
  title: title => `${title} - ${appName}`,
  resolve: name => require(`./Pages/${name}.vue`),
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(pinia)
      .mixin({ methods: { route } })
      .mount(el);
  }
});

InertiaProgress.init({ color: '#4B5563' });

const mainStore = useMainStore(pinia);

/* App style */
mainStore.setStyle(localStorage[styleKey] ?? 'basic');

/* Dark mode */
if (
  (!localStorage[darkModeKey] &&
    window.matchMedia('(prefers-color-scheme: dark)').matches) ||
  localStorage[darkModeKey] === '1'
) {
  mainStore.setDarkMode(true);
}

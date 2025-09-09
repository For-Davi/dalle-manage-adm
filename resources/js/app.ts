import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { Link } from '@inertiajs/vue3';
import { Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';

createInertiaApp({
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob('./pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });

    app.use(plugin)
       .component('InertiaLink', Link)
       .component('Toaster', Toaster); 

    app.mount(el);

    return app;
  },
  progress: {
    color: '#4B5563',
  },
});

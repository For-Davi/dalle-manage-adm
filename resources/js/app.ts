import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { Link } from '@inertiajs/vue3'

createInertiaApp({
  resolve: name =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob('./pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })

    app.use(plugin).component('InertiaLink', Link)

    app.mount(el)

    return app
  },
  progress: {
    color: '#4B5563',
  },
})
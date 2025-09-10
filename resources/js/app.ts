import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { Link } from '@inertiajs/vue3';
import { Toaster } from 'vue-sonner';
import 'vue-sonner/style.css';
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from './components/ui/card/index.js';
import { Input } from './components/ui/input/index.js';
import { Label } from './components/ui/label/index.js';
import { Button } from './components/ui/button/index.js';
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from './components/ui/dialog/index.js';
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarHeader,
  SidebarFooter,
} from './components/ui/sidebar/index.js';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableEmpty,
  TableFooter,
  TableHead,
  TableHeader,
  TableRow,
} from './components/ui/table/index.js';
import { Separator } from './components/ui/separator/index.js';

createInertiaApp({
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob('./pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });

    app
      .use(plugin)
      .component('Card', Card)
      .component('CardContent', CardContent)
      .component('CardHeader', CardHeader)
      .component('CardTitle', CardTitle)
      .component('CardFooter', CardFooter)
      .component('Dialog', Dialog)
      .component('DialogContent', DialogContent)
      .component('DialogHeader', DialogHeader)
      .component('DialogTitle', DialogTitle)
      .component('Input', Input)
      .component('Label', Label)
      .component('Button', Button)
      .component('Toaster', Toaster)
      .component('Link', Link)
      .component('Sidebar', Sidebar)
      .component('SidebarContent', SidebarContent)
      .component('SidebarGroup', SidebarGroup)
      .component('SidebarGroupContent', SidebarGroupContent)
      .component('SidebarMenu', SidebarMenu)
      .component('SidebarMenuButton', SidebarMenuButton)
      .component('SidebarMenuItem', SidebarMenuItem)
      .component('SidebarHeader', SidebarHeader)
      .component('SidebarFooter', SidebarFooter)
      .component('Separator', Separator)
      .component('Table', Table)
      .component('TableBody', TableBody)
      .component('TableCaption', TableCaption)
      .component('TableCell', TableCell)
      .component('TableEmpty', TableEmpty)
      .component('TableFooter', TableFooter)
      .component('TableHead', TableHead)
      .component('TableHeader', TableHeader)
      .component('TableRow', TableRow);

    app.mount(el);

    return app;
  },
  progress: {
    color: '#4B5563',
  },
});

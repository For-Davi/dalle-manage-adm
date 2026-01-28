import './bootstrap';
import '../css/app.css';
import { createApp, h } from 'vue';
import { createPinia } from 'pinia';
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
  DialogDescription,
  DialogOverlay,
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
  SidebarProvider,
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
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectItemText,
  SelectLabel,
  SelectScrollDownButton,
  SelectScrollUpButton,
  SelectSeparator,
  SelectTrigger,
  SelectValue,
} from './components/ui/select/index.js';
import { Loader2 } from 'lucide-vue-next';
import { Separator } from './components/ui/separator/index.js';
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuPortal,
  DropdownMenuRadioGroup,
  DropdownMenuRadioItem,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuSub,
  DropdownMenuSubContent,
  DropdownMenuSubTrigger,
  DropdownMenuTrigger,
} from './components/ui/dropdown-menu/index.js';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from './components/ui/tabs/index.js';
import { Spinner } from './components/ui/spinner/index';

createInertiaApp({
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      import.meta.glob('./pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });

    const pinia = createPinia();

    app
      .use(plugin)
      .use(pinia)
      .component('Card', Card)
      .component('CardContent', CardContent)
      .component('CardHeader', CardHeader)
      .component('CardTitle', CardTitle)
      .component('CardFooter', CardFooter)
      .component('Dialog', Dialog)
      .component('DialogContent', DialogContent)
      .component('DialogHeader', DialogHeader)
      .component('DialogTitle', DialogTitle)
      .component('DialogDescription', DialogDescription)
      .component('DialogOverlay', DialogOverlay)
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
      .component('SidebarProvider', SidebarProvider)
      .component('Separator', Separator)
      .component('Table', Table)
      .component('TableBody', TableBody)
      .component('TableCaption', TableCaption)
      .component('TableCell', TableCell)
      .component('TableEmpty', TableEmpty)
      .component('TableFooter', TableFooter)
      .component('TableHead', TableHead)
      .component('TableHeader', TableHeader)
      .component('TableRow', TableRow)
      .component('Select', Select)
      .component('SelectContent', SelectContent)
      .component('SelectGroup', SelectGroup)
      .component('SelectItem', SelectItem)
      .component('SelectItemText', SelectItemText)
      .component('SelectLabel', SelectLabel)
      .component('SelectScrollDownButton', SelectScrollDownButton)
      .component('SelectScrollUpButton', SelectScrollUpButton)
      .component('SelectSeparator', SelectSeparator)
      .component('SelectTrigger', SelectTrigger)
      .component('SelectValue', SelectValue)
      .component('Loader2', Loader2)
      .component('DropdownMenu', DropdownMenu)
      .component('DropdownMenuCheckboxItem', DropdownMenuCheckboxItem)
      .component('DropdownMenuContent', DropdownMenuContent)
      .component('DropdownMenuGroup', DropdownMenuGroup)
      .component('DropdownMenuItem', DropdownMenuItem)
      .component('DropdownMenuLabel', DropdownMenuLabel)
      .component('DropdownMenuPortal', DropdownMenuPortal)
      .component('DropdownMenuRadioGroup', DropdownMenuRadioGroup)
      .component('DropdownMenuRadioItem', DropdownMenuRadioItem)
      .component('DropdownMenuSeparator', DropdownMenuSeparator)
      .component('DropdownMenuShortcut', DropdownMenuShortcut)
      .component('DropdownMenuSub', DropdownMenuSub)
      .component('DropdownMenuSubContent', DropdownMenuSubContent)
      .component('DropdownMenuSubTrigger', DropdownMenuSubTrigger)
      .component('DropdownMenuTrigger', DropdownMenuTrigger)
      .component('Tabs', Tabs)
      .component('TabsContent', TabsContent)
      .component('TabsList', TabsList)
      .component('TabsTrigger', TabsTrigger)
      .component('Spinner', Spinner);

    app.mount(el);

    return app;
  },
  progress: {
    color: '#4B5563',
  },
});

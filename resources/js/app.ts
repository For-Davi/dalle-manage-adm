import './bootstrap';
import '../css/app.css';
import { registerLucideIcons } from './plugins/lucide';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import App from './App.vue';
import 'vue-sonner/style.css';
import { Toaster } from 'vue-sonner';
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

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.component('Card', Card);
app.component('CardContent', CardContent);
app.component('CardHeader', CardHeader);
app.component('CardTitle', CardTitle);
app.component('CardFooter', CardFooter);
app.component('Dialog', Dialog);
app.component('DialogContent', DialogContent);
app.component('DialogHeader', DialogHeader);
app.component('DialogTitle', DialogTitle);
app.component('DialogDescription', DialogDescription);
app.component('DialogOverlay', DialogOverlay);
app.component('Input', Input);
app.component('Label', Label);
app.component('Button', Button);
app.component('Toaster', Toaster);
app.component('Sidebar', Sidebar);
app.component('SidebarContent', SidebarContent);
app.component('SidebarGroup', SidebarGroup);
app.component('SidebarGroupContent', SidebarGroupContent);
app.component('SidebarMenu', SidebarMenu);
app.component('SidebarMenuButton', SidebarMenuButton);
app.component('SidebarMenuItem', SidebarMenuItem);
app.component('SidebarHeader', SidebarHeader);
app.component('SidebarFooter', SidebarFooter);
app.component('SidebarProvider', SidebarProvider);
app.component('Separator', Separator);
app.component('Table', Table);
app.component('TableBody', TableBody);
app.component('TableCaption', TableCaption);
app.component('TableCell', TableCell);
app.component('TableEmpty', TableEmpty);
app.component('TableFooter', TableFooter);
app.component('TableHead', TableHead);
app.component('TableHeader', TableHeader);
app.component('TableRow', TableRow);
app.component('Select', Select);
app.component('SelectContent', SelectContent);
app.component('SelectGroup', SelectGroup);
app.component('SelectItem', SelectItem);
app.component('SelectItemText', SelectItemText);
app.component('SelectLabel', SelectLabel);
app.component('SelectScrollDownButton', SelectScrollDownButton);
app.component('SelectScrollUpButton', SelectScrollUpButton);
app.component('SelectSeparator', SelectSeparator);
app.component('SelectTrigger', SelectTrigger);
app.component('SelectValue', SelectValue);
app.component('DropdownMenu', DropdownMenu);
app.component('DropdownMenuCheckboxItem', DropdownMenuCheckboxItem);
app.component('DropdownMenuContent', DropdownMenuContent);
app.component('DropdownMenuGroup', DropdownMenuGroup);
app.component('DropdownMenuItem', DropdownMenuItem);
app.component('DropdownMenuLabel', DropdownMenuLabel);
app.component('DropdownMenuPortal', DropdownMenuPortal);
app.component('DropdownMenuRadioGroup', DropdownMenuRadioGroup);
app.component('DropdownMenuRadioItem', DropdownMenuRadioItem);
app.component('DropdownMenuSeparator', DropdownMenuSeparator);
app.component('DropdownMenuShortcut', DropdownMenuShortcut);
app.component('DropdownMenuSub', DropdownMenuSub);
app.component('DropdownMenuSubContent', DropdownMenuSubContent);
app.component('DropdownMenuSubTrigger', DropdownMenuSubTrigger);
app.component('DropdownMenuTrigger', DropdownMenuTrigger);
app.component('Tabs', Tabs);
app.component('TabsContent', TabsContent);
app.component('TabsList', TabsList);
app.component('TabsTrigger', TabsTrigger);
app.component('Spinner', Spinner);

registerLucideIcons(app);

app.mount('#app');

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
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from '@/components/ui/breadcrumb/index';
import { Switch } from '@/components/ui/switch/index';
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
  CardAction,
  CardDescription,
} from './components/ui/card/index';
import { Input } from './components/ui/input/index';
import { Label } from './components/ui/label/index';
import { Button } from './components/ui/button/index';
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogOverlay,
  DialogFooter,
} from './components/ui/dialog/index';
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
} from './components/ui/sidebar/index';
import {
  Sheet,
  SheetClose,
  SheetContent,
  SheetDescription,
  SheetFooter,
  SheetHeader,
  SheetTitle,
  SheetTrigger,
} from './components/ui/sheet/index';
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
} from './components/ui/table/index';
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
} from './components/ui/select/index';
import { Separator } from './components/ui/separator/index';
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
} from './components/ui/dropdown-menu/index';
import {
  Calendar,
  CalendarCell,
  CalendarCellTrigger,
  CalendarGrid,
  CalendarHeader,
  CalendarGridBody,
  CalendarGridHead,
  CalendarGridRow,
  CalendarHeadCell,
  CalendarHeading,
  CalendarNextButton,
  CalendarPrevButton,
} from './components/ui/calendar/index';
import {
  Tabs,
  TabsContent,
  TabsList,
  TabsTrigger,
} from './components/ui/tabs/index';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover';
import { Spinner } from './components/ui/spinner/index';
import MenuActions from './components/shared/menu/MenuActions.vue';
import AppBreadcrumb from './components/shared/route/AppBreadcrumb.vue';

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.component('AppBreadcrumb', AppBreadcrumb);
app.component('MenuActions', MenuActions);
app.component('Breadcrumb', Breadcrumb);
app.component('Calendar', Calendar);
app.component('CalendarCell', CalendarCell);
app.component('CalendarCellTrigger', CalendarCellTrigger);
app.component('CalendarGrid', CalendarGrid);
app.component('CalendarHeader', CalendarHeader);
app.component('CalendarGridBody', CalendarGridBody);
app.component('CalendarGridHead', CalendarGridHead);
app.component('CalendarGridRow', CalendarGridRow);
app.component('CalendarHeadCell', CalendarHeadCell);
app.component('CalendarHeading', CalendarHeading);
app.component('CalendarNextButton', CalendarNextButton);
app.component('CalendarPrevButton', CalendarPrevButton);
app.component('Popover', Popover);
app.component('PopoverContent', PopoverContent);
app.component('PopoverTrigger', PopoverTrigger);
app.component('BreadcrumbItem', BreadcrumbItem);
app.component('BreadcrumbLink', BreadcrumbLink);
app.component('BreadcrumbList', BreadcrumbList);
app.component('BreadcrumbPage', BreadcrumbPage);
app.component('BreadcrumbSeparator', BreadcrumbSeparator);
app.component('Card', Card);
app.component('Sheet', Sheet);
app.component('SheetClose', SheetClose);
app.component('SheetContent', SheetContent);
app.component('SheetDescription', SheetDescription);
app.component('SheetFooter', SheetFooter);
app.component('SheetHeader', SheetHeader);
app.component('SheetTitle', SheetTitle);
app.component('SheetTrigger', SheetTrigger);
app.component('CardContent', CardContent);
app.component('CardHeader', CardHeader);
app.component('CardTitle', CardTitle);
app.component('CardAction', CardAction);
app.component('CardDescription', CardDescription);
app.component('CardFooter', CardFooter);
app.component('Dialog', Dialog);
app.component('DialogContent', DialogContent);
app.component('DialogHeader', DialogHeader);
app.component('DialogTitle', DialogTitle);
app.component('DialogDescription', DialogDescription);
app.component('DialogOverlay', DialogOverlay);
app.component('DialogFooter', DialogFooter);
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
app.component('Switch', Switch);

registerLucideIcons(app);

app.mount('#app');

<script setup lang="ts">
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
} from '@/components/ui/sidebar';
import { Separator } from '@/components/ui/separator';
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import FormProfile from '@/components/form/FormProfile.vue';
import {
  User,
  Building2,
  ChartNoAxesColumn,
  LogOut,
  SquarePen,
} from 'lucide-vue-next';

defineOptions({
  name: 'AppSidebar',
});

const showFormProfile = reactive<{
  open: boolean;
  user: IUser | null;
}>({
  open: false,
  user: null,
});
const items = [
  {
    title: 'Dashboard',
    url: '/dashboard',
    icon: ChartNoAxesColumn,
  },
  {
    title: 'Empresas',
    url: '/enterprises',
    icon: Building2,
  },
  {
    title: 'Clientes',
    url: '/clients',
    icon: User,
  },
];

const isActive = (url: string) => {
  return currentRoute.value === url || currentRoute.value.startsWith(url + '/');
};

const logout = () => {
  router.post(route('user.logout'), {
    onSuccess: () => {
      router.visit(route('login'));
    },
  });
};
const changeShowFormProfile = (
  show: boolean,
  user: IUser | null = null
): void => {
  Object.assign(showFormProfile, {
    open: show,
    user: user,
  });
};

const page = usePage();
const currentRoute = computed(() => page.url);
const user = computed(() => page.props.auth.user);
</script>

<template>
  <Sidebar>
    <SidebarHeader class="p-4">
      <h2 class="text-xl font-bold">Dalle Manage Adm</h2>
      <div class="flex">
        <p class="text-muted-foreground mr-2 text-sm">
          {{ user.name }}
        </p>
        <button
          @click="changeShowFormProfile(true, user)"
          class="hover:bg-accent hover:text-accent-foreground cursor-pointer rounded-md"
        >
          <SquarePen stroke-width="3" class="h-4 w-4" />
        </button>
      </div>
      <p class="text-muted-foreground text-sm">{{ user.name }}</p>
    </SidebarHeader>
    <Separator />
    <SidebarContent class="flex-1">
      <SidebarGroup>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
              <SidebarMenuButton asChild>
                <Link
                  :href="item.url"
                  :class="isActive(item.url) ? 'bg-accent font-bold' : ''"
                  class="hover:bg-accent hover:text-accent-foreground flex items-center gap-2 rounded-md p-2 transition-colors"
                >
                  <component
                    :is="item.icon"
                    class="h-4 w-4"
                    :strokeWidth="isActive(item.url) ? 2 : 1"
                  />
                  <span class="text-base">{{ item.title }}</span>
                </Link>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
    <SidebarFooter class="border-t p-4">
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton asChild>
            <form @submit.prevent="logout" class="w-full">
              <input
                type="hidden"
                name="_token"
                :value="page.props.csrf_token"
              />
              <button
                type="submit"
                class="text-destructive hover:bg-accent flex w-full cursor-pointer items-center gap-2 rounded-md p-2"
              >
                <LogOut class="h-4 w-4" />
                <span class="text-base font-bold">Sair</span>
              </button>
            </form>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarFooter>
  </Sidebar>
  <!-- Modals -->
  <FormProfile
    :data="showFormProfile"
    @update:open="changeShowFormProfile(false)"
  />
</template>

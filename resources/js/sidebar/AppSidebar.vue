<script setup lang="ts">
import { computed, reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import ProfileForm from '@/components/form/ProfileForm.vue';
import {
  User,
  Building2,
  ChartNoAxesColumn,
  LogOut,
  SquarePen,
  HandCoins,
  Store,
} from 'lucide-vue-next';
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth-store';

defineOptions({
  name: 'AppSidebar',
});

const route = useRoute();
const router = useRouter();

const { loadingAuth, user } = storeToRefs(useAuthStore());

const showFormProfile = reactive<{
  open: boolean;
  user: IUserAdm | null;
}>({
  open: false,
  user: null,
});

const items = [
  { title: 'Dashboard', url: '/adm/dashboard', icon: ChartNoAxesColumn },
  { title: 'Empresas', url: '/adm/enterprises', icon: Building2 },
  { title: 'Usuários', url: '/adm/users', icon: User },
  { title: 'Vendedores', url: '/adm/sellers', icon: Store },
  { title: 'Assinaturas', url: '/adm/subscriptions', icon: HandCoins },
];

const currentPath = computed(() => route.path);

const isActive = (url: string) => {
  return currentPath.value === url || currentPath.value.startsWith(url + '/');
};

const logout = async () => {
  await useAuthStore().logout();
  router.push({ name: 'auth' });
};

const changeShowFormProfile = (
  show: boolean,
  user: IUserAdm | null = null
): void => {
  Object.assign(showFormProfile, {
    open: show,
    user,
  });
};
</script>

<template>
  <Sidebar>
    <SidebarHeader class="p-4">
      <h2 class="text-xl font-bold">Dalle Manage Adm</h2>
      <div class="flex items-center">
        <p class="text-muted-foreground mr-2 text-sm">
          {{ user?.name ?? '-' }}
        </p>
        <button
          @click="changeShowFormProfile(true, user)"
          class="hover:bg-accent cursor-pointer rounded-md"
        >
          <SquarePen stroke-width="2" class="h-3 w-3" />
        </button>
      </div>
    </SidebarHeader>
    <Separator />
    <SidebarContent class="flex-1">
      <SidebarGroup>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
              <SidebarMenuButton asChild>
                <RouterLink
                  :to="item.url"
                  :class="isActive(item.url) ? 'bg-accent font-bold' : ''"
                  class="hover:bg-accent hover:text-accent-foreground flex items-center gap-2 rounded-md p-2 transition-colors"
                >
                  <component
                    :is="item.icon"
                    class="h-4 w-4"
                    :strokeWidth="isActive(item.url) ? 2 : 1"
                  />
                  <span class="text-base">{{ item.title }}</span>
                </RouterLink>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
    <SidebarFooter class="border-t p-4">
      <SidebarMenu>
        <SidebarMenuItem>
          <Button
            type="submit"
            @click="logout"
            variant="ghost"
            :disabled="loadingAuth"
          >
            <Spinner v-if="loadingAuth" class="animate-spin" />
            <LogOut v-else class="h-4 w-4" />
            <span>Sair</span>
          </Button>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarFooter>
  </Sidebar>
  <!-- Modals -->
  <ProfileForm
    :data="showFormProfile"
    @update:open="changeShowFormProfile(false)"
  />
</template>

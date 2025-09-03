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
} from '@/components/ui/sidebar'
import { Separator } from '@/components/ui/separator';
import { User, Building2, ChartNoAxesColumn, LogOut } from 'lucide-vue-next';
import { Link, usePage, router } from '@inertiajs/vue3'
import { computed } from 'vue'

defineOptions({
  name:'AppSidebar'
})

const items = [
  {
    title:'Dashboard',
    url: '/dashboard',
    icon: ChartNoAxesColumn
  },
  {
    title:'Empresas',
    url: '/enterprises',
    icon: Building2
  },
  {
    title:'Clientes',
    url: '/clients',
    icon: User,
  },
]

const isActive = (url: string) => {
  return currentRoute.value === url || currentRoute.value.startsWith(url + '/')
}

const logout = () => {
  router.post(route('user.logout'), {
    onSuccess: () => {
      router.visit(route('login'))
    }
  })
}

const page = usePage()
const currentRoute = computed(() => page.url)
const user = computed(() => page.props.auth.user)
</script>

<template>
  <Sidebar>
    <SidebarHeader class="p-4">
      <h2 class="text-xl font-bold">Dalle Manage Adm</h2>
      <p class="text-sm text-muted-foreground">{{ user.name }}</p>
    </SidebarHeader>
    <Separator/>
    <SidebarContent class="flex-1">
      <SidebarGroup>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
              <SidebarMenuButton asChild>
                <Link
                  :href="item.url"
                  :class="isActive(item.url) ? 'bg-accent font-bold' : ''"
                  class="flex items-center gap-2 p-2 rounded-md hover:bg-accent hover:text-accent-foreground transition-colors"
                >
                  <component
                    :is="item.icon"
                    class="w-4 h-4"
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
    <SidebarFooter class="p-4 border-t">
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton asChild>
            <form @submit.prevent="logout" class="w-full">
              <input type="hidden" name="_token" :value="page.props.csrf_token">
              <button type="submit" class="flex items-center gap-2 w-full cursor-pointer p-2 text-destructive hover:bg-accent rounded-md">
                <LogOut class="w-4 h-4"/>
                <span class="text-base font-bold">Sair</span>
              </button>
            </form>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarFooter>
  </Sidebar>
</template>
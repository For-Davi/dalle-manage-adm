<script setup lang="ts">
import AppSidebar from '@/sidebar/AppSidebar.vue';
import 'vue-sonner/style.css';
import { RouterView, useRoute } from 'vue-router';

defineOptions({
  name: 'MainLayout',
});

const route = useRoute();
</script>

<template>
  <SidebarProvider>
    <div class="flex h-screen w-screen bg-gray-50">
      <AppSidebar />
      <main class="flex-1 overflow-auto">
        <router-view :key="route.fullPath" />
        <Toaster />
      </main>
    </div>
  </SidebarProvider>
</template>

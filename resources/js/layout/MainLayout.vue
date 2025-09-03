<script setup lang="ts">
import AppSidebar from '@/sidebar/AppSidebar.vue';
import { SidebarProvider } from '@/components/ui/sidebar'
import 'vue-sonner/style.css'

defineOptions({
    name:'MainLayout'
})
</script>

<template>
<SidebarProvider>
    <div class="flex h-screen w-screen bg-gray-50">
        <AppSidebar/>
        <main class="flex-1 overflow-auto">
            <slot/>
        </main>
    </div>
</SidebarProvider>
</template>
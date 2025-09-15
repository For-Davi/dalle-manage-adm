<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import MainLayout from '@/layout/MainLayout.vue';
import TitlePage from '@/components/general/TitlePage.vue';

defineOptions({
  name: 'Dashboard',
});
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <TitlePage title="Dashboard" />
      <Separator class="my-4" />
    </div>
  </MainLayout>
</template>

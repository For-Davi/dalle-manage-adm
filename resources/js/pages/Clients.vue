<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import MainLayout from '@/layout/MainLayout.vue';

defineOptions({
  name: 'Clients',
});
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <h1 class="text-xl font-bold">Clientes</h1>
      <Separator class="my-4" />
    </div>
  </MainLayout>
</template>

<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import TitlePage from '@/components/general/TitlePage.vue';

defineOptions({
  name: 'Seller Registration',
});
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <TitlePage title="Seller Registration" />
      <Separator class="my-4" />
    </div>
  </MainLayout>
</template>

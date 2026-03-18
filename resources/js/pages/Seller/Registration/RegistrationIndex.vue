<script setup lang="ts">
import { computed, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { useSellerStore } from '@/stores/seller-store';
import RegistrationsTable from '@/components/table/RegistrationsTable.vue';

defineOptions({
  name: 'RegistrationIndex',
});

const fetchRegistrations = async () => {
  await useSellerStore().getSellersRegistration();
};

const breadcrumbItems = computed<IBreadcrumbItem[]>(() => [
  {
    label: 'Vendedores',
    to: { name: 'sellers' },
  },
  {
    label: 'Inscrições',
  },
]);

onMounted(async () => {
  await fetchRegistrations();
});
</script>

<template>
  <main class="p-6">
    <TitlePage title="Inscrições" />
    <Separator class="my-4" />
    <AppBreadcrumb :items="breadcrumbItems" />
    <RegistrationsTable />
  </main>
</template>

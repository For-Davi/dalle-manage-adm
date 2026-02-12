<script setup lang="ts">
import { onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { useSellerStore } from '@/stores/seller-store';
import RegistrationsTable from '@/components/tables/RegistrationsTable.vue';

defineOptions({
  name: 'RegistrationIndex',
});

const fetchRegistrations = async () => {
  await useSellerStore().getSellersRegistration();
};

onMounted(async () => {
  await fetchRegistrations();
});
</script>

<template>
  <main>
    <div class="p-6">
      <TitlePage title="Inscrições" />
      <Separator class="my-4" />
      <Breadcrumb class="mb-4">
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink class="cursor-pointer" as-child>
              <RouterLink :to="{ name: 'sellers' }"> Vendedores </RouterLink>
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbLink class="font-bold"> Inscrições </BreadcrumbLink>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
      <RegistrationsTable />
    </div>
  </main>
</template>

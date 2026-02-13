<script setup lang="ts">
import { computed, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { goUrlName } from '@/composables/useRedirect';
import { storeToRefs } from 'pinia';
import { useSellerStore } from '@/stores/seller-store';
import SellersTable from '@/components/table/SellersTable.vue';

defineOptions({
  name: 'SellerIndex',
});

const { loadingSeller } = storeToRefs(useSellerStore());

const actions = computed(() => [
  {
    label: 'Inscrições',
    icon: 'LucideUserPlus',
    variant: 'outline',
    onClick: () => goUrlName('registrations'),
    disabled: loadingSeller.value,
  },
  {
    label: 'Criar vendedor',
    icon: 'LucidePlus',
    class: 'bg-black',
    disabled: loadingSeller.value,
    onClick: () => goUrlName('seller.create'),
  },
]);

onMounted(async () => {
  await useSellerStore().getSellers();
});
</script>

<template>
  <main class="p-6">
    <TitlePage title="Vendedores" />
    <Separator class="my-4" />
    <MenuActions :actions="actions" />
    <SellersTable />
  </main>
</template>

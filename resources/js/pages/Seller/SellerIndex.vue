<script setup lang="ts">
import { onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { goUrlName } from '@/composables/useRedirect';
import { useSellerStore } from '@/stores/seller-store';
import SellersTable from '@/components/tables/SellersTable.vue';

defineOptions({
  name: 'SellerIndex',
});

onMounted(async () => {
  await useSellerStore().getSellers();
});
</script>

<template>
  <main>
    <div class="p-6">
      <TitlePage title="Vendedores" />
      <Separator class="my-4" />
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="goUrlName('seller.create')"
        >
          Criar vendedor
          <LucidePlus />
        </Button>
      </div>
      <SellersTable />
    </div>
  </main>
</template>

<script setup lang="ts">
import TitlePage from '@/components/general/TitlePage.vue';
import SellersTable from '@/components/tables/SellersTable.vue';
import { Plus, UserRoundSearch } from 'lucide-vue-next';
import SellerForm from '@/components/form/SellerForm.vue';
import { reactive, onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useSellerStore } from '@/stores/seller-store';

defineOptions({
  name: 'Seller',
});

const {loadingSeller, listSellers} = storeToRefs(useSellerStore());


const showSellerForm = reactive<{
  open: boolean;
  seller: ISeller | null;
}>({
  open: false,
  seller: null,
});

const changeShowSellerForm = (show: boolean, seller: ISeller | null = null) => {
  Object.assign(showSellerForm, {
    open: show,
    seller: seller,
  });
};
const startEdit = (seller: ISeller) => {
  changeShowSellerForm(true, seller);
};

const fetchSellers = async () => {
  await useSellerStore().getSellers();
};

onMounted(async () => {
  await fetchSellers();
});
</script>

<template>
    <main>
        <div v-if="!loadingSeller" class="p-6">
          <TitlePage title="Vendedores" />
          <Separator class="my-4" />
          <div class="m-3 flex justify-end gap-2">
            <Button
              class="cursor-pointer"
              variant="outline"
              @click="changeShowSellerForm(true)"
            >
              Inscrições
              <UserRoundSearch />
            </Button>
            <Button class="cursor-pointer" @click="changeShowSellerForm(true)">
              Criar vendedor
              <Plus />
            </Button>
          </div>
          <SellersTable :sellers="listSellers" @edit:seller="startEdit" />
        </div>
        <div v-else class="p-6" >
          <Spinner  class="size-8" />
        </div>

        <!-- Modals -->
        <SellerForm
          :data="showSellerForm"
          @update:open="changeShowSellerForm(false)"
        />
    </main>

</template>

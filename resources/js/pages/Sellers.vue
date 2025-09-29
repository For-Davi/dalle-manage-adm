<script setup lang="ts">
import MainLayout from '@/layout/MainLayout.vue';
import TitlePage from '@/components/general/TitlePage.vue';
import SellersTable from '../components/tables/SellersTable.vue';
import { Plus } from 'lucide-vue-next';
import SellerForm from '@/components/form/SellerForm.vue';
import { reactive, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

defineOptions({
  name: 'Sellers',
});

const props = defineProps<{
  sellers: ISeller[];
}>();

const page = usePage();

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

watch(
  () => page,
  () => {
    if (page.props.flash.success) {
      toast.success(page.props.flash.success);
    }
  },
  { immediate: true, deep: true }
);
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <TitlePage title="Vendedores" />
      <Separator class="my-4" />
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="changeShowSellerForm(true)"
        >
          Criar vendedor
          <Plus />
        </Button>
      </div>
      <SellersTable :sellers="props.sellers" @edit:seller="startEdit" />
    </div>
  </MainLayout>
  <!-- Modals -->
  <SellerForm
    :data="showSellerForm"
    @update:open="changeShowSellerForm(false)"
  />
</template>

<script setup lang="ts">
import MainLayout from '@/layout/MainLayout.vue';
import EnterprisesTable from '@/components/tables/EnterprisesTable.vue';
import { Plus } from 'lucide-vue-next';
import EnterpriseForm from '@/components/form/EnterpriseForm.vue';
import { reactive } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

defineOptions({
  name: 'Enterprises',
});

const props = defineProps<{
  enterprises: IEnterprise[];
}>();

const page = usePage();

const showEnterpriseForm = reactive<{
  open: boolean;
  enterprise: IEnterprise | null;
}>({
  open: false,
  enterprise: null,
});

const changeShowEnterpriseForm = (
  show: boolean,
  enterprise: IEnterprise | null = null
): void => {
  Object.assign(showEnterpriseForm, {
    open: show,
    enterprise: enterprise,
  });
};
const startEdit = (enterprise: IEnterprise) => {
  changeShowEnterpriseForm(true, enterprise);
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
      <TitlePage title="Empresas" />
      <Separator class="my-4" />
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="changeShowEnterpriseForm(true)"
        >
          Criar empresa
          <Plus />
        </Button>
      </div>
      <EnterprisesTable
        :enterprises="props.enterprises"
        @edit:enterprise="startEdit"
      />
    </div>
  </MainLayout>

  <!-- Modals -->
  <EnterpriseForm
    :data="showEnterpriseForm"
    @update:open="changeShowEnterpriseForm(false)"
  />
</template>

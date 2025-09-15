<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import MainLayout from '@/layout/MainLayout.vue';
import EnterprisesTable from '@/components/tables/EnterprisesTable.vue';
import { Plus } from 'lucide-vue-next';
import EnterpriseForm from '@/components/form/EnterpriseForm.vue';
import { ref } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';

defineOptions({
  name: 'Enterprises',
});

const props = defineProps<{
  enterprises: IEnterprises;
}>();

const showEnterpriseForm = ref<boolean>(false);

const changeShowEnterpriseForm = () => {
  showEnterpriseForm.value = !showEnterpriseForm.value;
};
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <TitlePage title="Empresas" />
      <Separator class="my-4" />
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="changeShowEnterpriseForm"
        >
          Criar empresa
          <Plus />
        </Button>
      </div>
      <EnterprisesTable :enterprises="props.enterprises" />
    </div>
  </MainLayout>

  <!-- Modals -->
  <EnterpriseForm
    :open="showEnterpriseForm"
    @update:open="changeShowEnterpriseForm"
  />
</template>

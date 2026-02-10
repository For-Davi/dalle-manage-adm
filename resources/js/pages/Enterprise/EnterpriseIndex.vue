<script setup lang="ts">
import EnterprisesTable from '@/components/tables/EnterprisesTable.vue';
import { onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { goUrlName } from '@/composables/useRedirect';

defineOptions({
  name: 'Enterprise',
});

const { loadingEnterprise, listEnterprises } =
  storeToRefs(useEnterpriseStore());

const fetchEnterprises = async () => {
  await useEnterpriseStore().getEnterprises();
};

onMounted(async () => {
  await fetchEnterprises();
});
</script>

<template>
  <main>
    <div v-if="!loadingEnterprise">
      <div class="p-6">
        <TitlePage title="Empresas" />
        <Separator class="my-4" />
        <div class="m-3 flex justify-end">
          <Button
            class="cursor-pointer bg-black"
            @click="goUrlName('enterprise.create')"
          >
            Criar empresa
            <LucidePlus />
          </Button>
        </div>
        <EnterprisesTable :enterprises="listEnterprises" />
      </div>
    </div>
    <div class="p-6" v-else>
      <Spinner class="size-8" />
    </div>
  </main>
</template>

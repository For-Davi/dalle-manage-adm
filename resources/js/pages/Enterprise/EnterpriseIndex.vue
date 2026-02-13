<script setup lang="ts">
import EnterprisesTable from '@/components/table/EnterprisesTable.vue';
import { computed, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { goUrlName } from '@/composables/useRedirect';

defineOptions({
  name: 'Enterprise',
});

const { loadingEnterprise } = storeToRefs(useEnterpriseStore());

const fetchEnterprises = async () => {
  await useEnterpriseStore().getEnterprises();
};

const actions = computed(() => [
  {
    label: 'Criar empresa',
    icon: 'LucidePlus',
    class: 'bg-black',
    disabled: loadingEnterprise.value,
    onClick: () => goUrlName('enterprise.create'),
  },
]);

onMounted(async () => {
  await fetchEnterprises();
});
</script>

<template>
  <main class="p-6">
    <TitlePage title="Empresas" />
    <Separator class="my-4" />
    <MenuActions :actions="actions" />
    <EnterprisesTable />
  </main>
</template>

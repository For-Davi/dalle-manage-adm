<script setup lang="ts">
import { computed, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { goUrlName } from '@/composables/useRedirect';
import { storeToRefs } from 'pinia';
import UsersDmTable from '@/components/table/UsersDmTable.vue';

defineOptions({
  name: 'EnterpriseUserIndex',
});

const props = defineProps<{
  id: string;
}>();

const { loadingEnterprise } = storeToRefs(useEnterpriseStore());

const actions = computed<IMenuAction[]>(() => [
  {
    label: 'Criar usuário',
    class: 'bg-black',
    icon: 'LucidePlus',
    disabled: loadingEnterprise.value,
    onClick: () => goUrlName('enterprise-user.create', { id: props.id }),
  },
]);
const breadcrumbItems = computed<IBreadcrumbItem[]>(() => [
  {
    label: 'Empresas',
    to: { name: 'enterprises' },
  },
  {
    label: 'Usuários',
  },
]);

onMounted(async () => {
  await useEnterpriseStore().getUsersByEnterprise(Number(props.id));
});
</script>

<template>
  <main>
    <div class="p-6">
      <TitlePage title="Empresas" />
      <Separator class="my-4" />
      <AppBreadcrumb :items="breadcrumbItems" />
      <MenuActions :actions="actions" />
      <UsersDmTable :enterprise-id="props.id" />
    </div>
  </main>
</template>

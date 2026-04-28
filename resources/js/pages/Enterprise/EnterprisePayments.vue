<script setup lang="ts">
import { onMounted, computed, ref, reactive } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import EnterprisesPaymentsTable from '@/components/table/EnterprisesPaymentsTable.vue';
import { storeToRefs } from 'pinia';
import EnterprisePaymentFilter from './EnterprisePaymentFilter.vue';

defineOptions({
    name:'EnterprisePayments'
});

const { loadingEnterprise } = storeToRefs(useEnterpriseStore());

const showEnterprisePaymentFilter = ref<boolean>(false);
const filter = reactive({
  startDate: '',
  endDate: '',
  enterprise:'',
  status: null,
})

const fetchEnterprisePayments = async () => {
  await useEnterpriseStore().getEnterprisesPayments();
};
const changeShowEnterprisePaymentFilter = () => {
  showEnterprisePaymentFilter.value = !showEnterprisePaymentFilter.value;
};
const actionFilter = async (data: 'close' | IFilterEnterprisePayment): Promise<void> => {
  changeShowEnterprisePaymentFilter();

  if (data && typeof data === 'object') {
    Object.assign(filter, {
      startDate: data.startDate,
      endDate: data.endDate,
      enterprise: data.enterprise,
      status: data.status,
    });
    await useEnterpriseStore().getEnterprisesPayments(filter);
  }
};

const breadcrumbItems = computed<IBreadcrumbItem[]>(() => [
  {
    label: 'Empresas',
    to: { name: 'enterprises' },
  },
  {
    label: 'Pagamentos',
  },
]);

const actions = computed(() => [
  {
    label: 'Filtro',
    icon: 'LucideFunnel',
    class: 'bg-black cursor-pointer',
    disabled: loadingEnterprise.value,
    badge: hasFilter.value,
    onClick: () => changeShowEnterprisePaymentFilter(),
  },
]);
const hasFilter = computed(() => {
  return filter.startDate !== '' || filter.endDate !== '' || filter.enterprise !== '' || filter.status !== null;
});

onMounted(async () => {
  await fetchEnterprisePayments();
});
</script>

<template>
    <main class="p-6">
    <TitlePage title="Histórico de Pagamentos" />
    <AppBreadcrumb :items="breadcrumbItems" />
    <Separator class="my-4" />
    <MenuActions :actions="actions" />
    <EnterprisesPaymentsTable/>
    <!-- Modals -->
    <EnterprisePaymentFilter :open="showEnterprisePaymentFilter" :filter="filter" @update:open="actionFilter"/>
  </main>
</template>
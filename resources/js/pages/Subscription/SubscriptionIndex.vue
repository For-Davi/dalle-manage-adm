<script setup lang="ts">
import SubscriptionsTable from '@/components/table/SubscriptionsTable.vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { onMounted } from 'vue';
import { useSubscriptionStore } from '@/stores/subscription-store';

defineOptions({
  name: 'SubscriptionIndex',
});

const fetchSubscriptions = async () => {
  await useSubscriptionStore().getSubscriptions();
};

onMounted(async () => {
  await fetchSubscriptions();
});
</script>

<template>
  <main class="p-6">
    <TitlePage title="Assinaturas" />
    <Separator class="my-4" />
    <SubscriptionsTable />
  </main>
</template>

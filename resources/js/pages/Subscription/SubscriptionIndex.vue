<script setup lang="ts">
import SubscriptionsTable from '@/components/tables/SubscriptionsTable.vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';
import { useSubscriptionStore } from '@/stores/subscription-store';

defineOptions({
  name: 'SubscriptionIndex',
});

const { loadingSubscription, listSubscriptions } = storeToRefs(
  useSubscriptionStore()
);

const fetchSubscriptions = async () => {
  await useSubscriptionStore().getSubscriptions();
};

onMounted(async () => {
  await fetchSubscriptions();
});
</script>

<template>
  <div class="p-6" v-if="!loadingSubscription">
    <TitlePage title="Assinaturas" />
    <Separator class="my-4" />
    <SubscriptionsTable :subscriptions="listSubscriptions" />
  </div>
  <div class="p-6" v-else>
    <Spinner class="size-8" />
  </div>
</template>

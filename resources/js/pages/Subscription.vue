<script setup lang="ts">
import MainLayout from '@/layout/MainLayout.vue';
import SubscriptionsTable from '@/components/tables/SubscriptionsTable.vue';
import TitlePage from '@/components/general/TitlePage.vue';

defineOptions({
  name: 'Subscription',
});

const props = defineProps<{
  subscriptions: ISubscriptions;
}>();
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <TitlePage title="Assinaturas" />
      <Separator class="my-4" />
      <SubscriptionsTable :subscriptions="props.subscriptions" />
    </div>
  </MainLayout>
</template>

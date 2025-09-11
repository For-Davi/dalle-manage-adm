<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import MainLayout from '@/layout/MainLayout.vue';
import SubscriptionsTable from '@/components/tables/SubscriptionsTable.vue';

defineOptions({
  name: 'Subscriptions',
});

const props = defineProps<{
  subscriptions: ISubscriptions;
}>();
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <h1 class="text-xl font-bold">Assinaturas</h1>
      <Separator class="my-4" />
      <SubscriptionsTable :subscriptions="props.subscriptions" />
    </div>
  </MainLayout>
</template>

<script setup lang="ts">
import { formatPriceBR } from '@/composables/useFormat';
import { getNameSubscription } from '@/composables/useSubscription';
import { storeToRefs } from 'pinia';
import { useSubscriptionStore } from '@/stores/subscription-store';

defineOptions({
  name: 'SubscriptionsTable',
});

const { listSubscriptions, loadingSubscription } = storeToRefs(
  useSubscriptionStore()
);
</script>

<template>
  <main>
    <Table v-if="!loadingSubscription">
      <TableHeader>
        <TableRow>
          <TableHead> Status </TableHead>
          <TableHead>Nome</TableHead>
          <TableHead>Preço</TableHead>
          <TableHead>Quantidades de empresas</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow
          v-for="(subscription, index) in listSubscriptions"
          :key="index"
        >
          <TableCell>
            <LucideCircleCheckBig
              v-if="subscription.active === 1"
              class="h-5 w-5 text-green-600"
            />
            <LucideCircleX v-else class="h-5 w-5 text-red-600" />
          </TableCell>
          <TableCell>{{ getNameSubscription(subscription.name) }}</TableCell>
          <TableCell>R$ {{ formatPriceBR(subscription.price) }}</TableCell>
          <TableCell>
            {{ subscription.enterprises_count }}
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
    <div class="p-6" v-else>
      <Spinner class="size-8" />
    </div>
  </main>
</template>

<script setup lang="ts">
import { formatPriceBR } from '@/composables/useFormt';
import { getNameSubscription } from '@/composables/useSubscription';

defineOptions({
  name: 'SubscriptionsTable',
});

const props = defineProps<{
  subscriptions: ISubscription[];
}>();
</script>

<template>
  <Table>
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
        v-for="(subscription, index) in props.subscriptions"
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
</template>

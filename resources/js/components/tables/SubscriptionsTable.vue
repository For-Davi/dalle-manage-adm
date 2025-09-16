<script setup lang="ts">
import { CircleCheckBig } from 'lucide-vue-next';
import { CircleX } from 'lucide-vue-next';
import { formatPriceBR } from '@/composables/FormatPrice';
import { getNameSubscription } from '@/composables/Subscription';

defineOptions({
  name: 'SubscriptionsTable',
});

const props = defineProps<{
  subscriptions: ISubscriptions[];
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
        v-for="(subscription , index) in props.subscriptions"
        :key="index"
      >
        <TableCell>
          <CircleCheckBig
            v-if="subscription.active === 1"
            class="h-5 w-5 text-green-600"
          />
          <CircleX v-else class="h-5 w-5 text-red-600" />
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

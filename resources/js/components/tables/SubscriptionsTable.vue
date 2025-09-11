<script setup lang="ts">
defineOptions({
  name: 'SubscriptionsTable',
});

import { CircleCheckBig } from 'lucide-vue-next';
import { CircleX } from 'lucide-vue-next';

const props = defineProps<{
  subscriptions: ISubscriptions;
}>();

function formatPriceBR(value: number): string {
  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(value);
}

function translateName(name: string) {
  if (name === 'free') {
    return 'Grátis';
  }
  if (name === 'basic') {
    return 'Básico';
  }
  if (name === 'premium') {
    return 'Premium';
  }
}
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
        v-for="subscriptions in props.subscriptions"
        :key="subscriptions.name"
      >
        <TableCell>
          <CircleCheckBig
            v-if="subscriptions.active === 1"
            class="h-5 w-5 text-green-600"
          />
          <CircleX v-else class="h-5 w-5 text-red-600" />
        </TableCell>
        <TableCell>{{ translateName(subscriptions.name) }}</TableCell>
        <TableCell>R$ {{ formatPriceBR(subscriptions.price) }}</TableCell>
        <TableCell>
          {{ subscriptions.enterprises_count }}
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>

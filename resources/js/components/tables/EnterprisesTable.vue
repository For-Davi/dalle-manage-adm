<script setup lang="ts">
defineOptions({
  name: 'EnterprisesTable',
});

import { CircleCheckBig } from 'lucide-vue-next';
import { CircleX } from 'lucide-vue-next';

const props = defineProps<{
  enterprises: IEnterprises;
}>();

function subscriptionUsed(value: number) {
  if (value === 1) {
    return 'Grátis';
  }
  if (value === 2) {
    return 'Básico';
  }
  if (value === 3) {
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
        <TableHead>Email</TableHead>
        <TableHead> Assinatura </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow
        v-for="enterprises in props.enterprises"
        :key="enterprises.name"
      >
        <TableCell>
          <CircleCheckBig
            v-if="enterprises.active === 1"
            class="h-5 w-5 text-green-600"
          />
          <CircleX v-else class="h-5 w-5 text-red-600" />
        </TableCell>
        <TableCell>{{ enterprises.name }}</TableCell>
        <TableCell>{{ enterprises.email }}</TableCell>
        <TableCell>
          {{ subscriptionUsed(enterprises.subscription_id) }}
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>

<script setup lang="ts">
import { CircleCheckBig, CircleX } from 'lucide-vue-next';
import { isActive } from '@/composables/Active';
import { getNameSubscription } from '@/composables/Subscription';

defineOptions({
  name: 'EnterprisesTable',
});

const props = defineProps<{
  enterprises: IEnterprise[];
}>();
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
      <TableRow v-for="(enterprise, index) in props.enterprises" :key="index">
        <TableCell>
          <CircleCheckBig
            v-if="isActive(enterprise.active)"
            class="h-5 w-5 text-green-600"
          />
          <CircleX v-else class="h-5 w-5 text-red-600" />
        </TableCell>
        <TableCell>{{ enterprise.name }}</TableCell>
        <TableCell>{{ enterprise.email }}</TableCell>
        <TableCell>
          {{ getNameSubscription(enterprise.subscription.name) }}
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { getPaymentStatus } from '@/composables/usePayment';
import { getNameSubscription } from '@/composables/useSubscription';
import { formatToBrazilianDate } from '@/composables/useDate';
import { getPaymentType } from '@/composables/usePayment';
import { computed } from 'vue';

defineOptions({
    name:'EnterprisesPaymentsTable'
});

const { loadingEnterprise, listEnterprisesPayments } =
  storeToRefs(useEnterpriseStore());

const sortedPayments = computed(() =>
  [...listEnterprisesPayments.value].sort(
    (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
  )
);
</script>

<template>
  <main>
    <Table v-if="!loadingEnterprise">
      <TableHeader>
        <TableRow>
          <TableHead>Status</TableHead>
          <TableHead>Empresa</TableHead>
          <TableHead>Email (empresa)</TableHead>
          <TableHead>Tipo do pagamento</TableHead>
          <TableHead>Assinatura</TableHead>
          <TableHead>Qtde. de mês</TableHead>
          <TableHead>Data</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="payment in sortedPayments" :key="payment.id">
          <TableCell>{{ getPaymentStatus(payment.status) }}</TableCell>
          <TableCell class="font-medium">{{ payment.enterprise_name }}</TableCell>
          <TableCell>{{ payment.enterprise_email }}</TableCell>
          <TableCell>{{ getPaymentType(payment.payment_type) }}</TableCell>
          <TableCell>{{
            getNameSubscription(payment.subscription)
          }}</TableCell>
          <TableCell>{{ payment.month_qnty }}</TableCell>
          <TableCell>{{ formatToBrazilianDate(payment.created_at) }}</TableCell>
        </TableRow>
      </TableBody>
    </Table>
    <div class="p-6" v-else>
      <Spinner class="size-8" />
    </div>
  </main>
</template>
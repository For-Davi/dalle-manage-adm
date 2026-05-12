<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { getPaymentStatus } from '@/composables/usePayment';
import { getNameSubscription } from '@/composables/useSubscription';
import { formatToBrazilianDate } from '@/composables/useDate';
import { getPaymentType } from '@/composables/usePayment';
import { computed, ref } from 'vue';

defineOptions({
  name: 'EnterprisesPaymentsTable',
});

const { loadingEnterprise, listEnterprisesPayments } =
  storeToRefs(useEnterpriseStore());

const currentPage = ref(1);
const itemsPerPage = 10;

const sortedPayments = computed(() =>
  [...listEnterprisesPayments.value].sort(
    (a, b) =>
      new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
  )
);

const paginatedPayments = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  return sortedPayments.value.slice(start, start + itemsPerPage);
});
</script>

<template>
  <main>
    <template v-if="!loadingEnterprise">
      <Table>
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
          <TableRow v-for="payment in paginatedPayments" :key="payment.id">
            <TableCell>{{ getPaymentStatus(payment.status) }}</TableCell>
            <TableCell class="font-medium">{{
              payment.enterprise_name
            }}</TableCell>
            <TableCell>{{ payment.enterprise_email }}</TableCell>
            <TableCell>{{ getPaymentType(payment.payment_type) }}</TableCell>
            <TableCell>{{
              getNameSubscription(payment.subscription)
            }}</TableCell>
            <TableCell>{{ payment.month_qnty }}</TableCell>
            <TableCell>{{
              formatToBrazilianDate(payment.created_at)
            }}</TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <Pagination
        v-model:page="currentPage"
        :total="sortedPayments.length"
        :items-per-page="itemsPerPage"
        :sibling-count="1"
        show-edges
        class="mt-4"
      >
        <PaginationContent v-slot="{ items }">
          <div class="flex items-center gap-1">
            <PaginationFirst />
            <PaginationPrevious />

            <template v-for="(item, index) in items" :key="index">
              <PaginationItem
                v-if="item.type === 'page'"
                :value="item.value"
                as-child
              >
                <Button
                  :variant="item.value === currentPage ? 'default' : 'outline'"
                  class="size-9 p-0"
                >
                  {{ item.value }}
                </Button>
              </PaginationItem>
              <PaginationEllipsis v-else :index="index" />
            </template>

            <PaginationNext />
            <PaginationLast />
          </div>
        </PaginationContent>
      </Pagination>
    </template>

    <div class="p-6" v-else>
      <Spinner class="size-8" />
    </div>
  </main>
</template>

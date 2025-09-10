<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import MainLayout from '@/layout/MainLayout.vue';
import EnterprisesTable from '@/components/tables/EnterprisesTable.vue';

defineOptions({
  name: 'Enterprises',
});

const props = defineProps<{
  enterprises: IEnterprises;
}>();
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <h1 class="text-xl font-bold">Empresas</h1>
      <Separator class="my-4" />
      <EnterprisesTable :enterprises="props.enterprises" />
    </div>
  </MainLayout>
</template>

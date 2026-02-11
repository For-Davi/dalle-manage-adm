<script setup lang="ts">
import { onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { goUrlName } from '@/composables/useRedirect';
import UsersDmTable from '@/components/tables/UsersDmTable.vue';

defineOptions({
  name: 'EnterpriseUserIndex',
});

const props = defineProps<{
  id: string;
}>();

onMounted(async () => {
  await useEnterpriseStore().getUsersByEnterprise(Number(props.id));
});
</script>

<template>
  <main>
    <div class="p-6">
      <TitlePage title="Empresas" />
      <Separator class="my-4" />
      <Breadcrumb class="mb-4">
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink class="cursor-pointer" as-child>
              <RouterLink :to="{ name: 'enterprises' }"> Empresas </RouterLink>
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbLink class="cursor-pointer font-bold">
              Usuários
            </BreadcrumbLink>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="goUrlName('enterprise-user.create', { id: props.id })"
        >
          Criar usuário
          <LucidePlus />
        </Button>
      </div>
      <UsersDmTable :enterprise-id="props.id" />
    </div>
  </main>
</template>

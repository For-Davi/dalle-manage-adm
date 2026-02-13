<script setup lang="ts">
import { computed, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { goUrlName } from '@/composables/useRedirect';
import UsersTable from '@/components/table/UsersTable.vue';
import { useUserAdmStore } from '@/stores/user-adm-store';

defineOptions({
  name: 'UserIndex',
});

const actions = computed<IMenuAction[]>(() => [
  {
    label: 'Criar usuário',
    class: 'bg-black',
    icon: 'LucidePlus',
    onClick: () => goUrlName('user.create'),
  },
]);

onMounted(async () => {
  await useUserAdmStore().getUsersAdm();
});
</script>

<template>
  <main class="p-6">
    <TitlePage title="Usuários" />
    <Separator class="my-4" />
    <MenuActions :actions="actions" />
    <UsersTable />
  </main>
</template>

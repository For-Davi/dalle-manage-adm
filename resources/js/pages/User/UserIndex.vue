<script setup lang="ts">
import { onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { goUrlName } from '@/composables/useRedirect';
import UsersTable from '@/components/table/UsersTable.vue';
import { useUserAdmStore } from '@/stores/user-adm-store';

defineOptions({
  name: 'UserIndex',
});

onMounted(async () => {
  await useUserAdmStore().getUsersAdm();
});
</script>

<template>
  <main>
    <div class="p-6">
      <TitlePage title="Usuários" />
      <Separator class="my-4" />
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="goUrlName('user.create')"
        >
          Criar usuário
          <LucidePlus />
        </Button>
      </div>
      <UsersTable />
    </div>
  </main>
</template>

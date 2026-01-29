<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import TitlePage from '@/components/general/TitlePage.vue';
import UsersTable from '@/components/tables/UsersTable.vue';
import { reactive, onMounted } from 'vue';
import UserForm from '@/components/form/UserForm.vue';
import { storeToRefs } from 'pinia';
import { useUserAdmStore } from '@/stores/user-adm-store';

defineOptions({
  name: 'User',
});

const { loadingUserAdm, listUsersAdm } = storeToRefs(useUserAdmStore());

const showUserForm = reactive<{
  open: boolean;
  user: IUserAdm | null;
}>({
  open: false,
  user: null,
});

const changeShowUserForm = (
  show: boolean,
  user: IUserAdm | null = null
): void => {
  Object.assign(showUserForm, {
    open: show,
    user: user,
  });
};
const startEdit = (user: IUserAdm) => {
  if (user) {
    changeShowUserForm(true, user);
  }
};

const fetchUsers = async () => {
  await useUserAdmStore().getUsersAdm();
};

onMounted(async () => {
  await fetchUsers();
});
</script>

<template>
  <main>
    <div v-if="!loadingUserAdm" class="p-6">
      <TitlePage title="Usuários" />
      <Separator class="my-4" />
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="changeShowUserForm(true)"
        >
          Criar usuário
          <Plus />
        </Button>
      </div>
      <UsersTable :users="listUsersAdm" @edit:user="startEdit" />
    </div>
    <div class="p-6" v-else>
      <Spinner class="size-8" />
    </div>
    <!-- Modals -->
    <UserForm :data="showUserForm" @update:open="changeShowUserForm(false)" />
  </main>
</template>

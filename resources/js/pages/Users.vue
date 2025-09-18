<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import MainLayout from '@/layout/MainLayout.vue';
import TitlePage from '@/components/general/TitlePage.vue';
import UsersTable from '@/components/tables/UsersTable.vue';
import { reactive, computed } from 'vue';
import UserForm from '@/components/form/UserForm.vue';
import { usePage } from '@inertiajs/vue3';

defineOptions({
  name: 'Users',
});

const page = usePage();

const props = defineProps<{
  users: IUser[];
}>();

const showUserForm = reactive<{
  open: boolean;
  user: IUser | null;
}>({
  open: false,
  user: null,
});

const changeShowUserForm = (show: boolean, user: IUser | null = null): void => {
  Object.assign(showUserForm, {
    open: show,
    user: user,
  });
};
const startEdit = (user: IUser) => {
  if (user) {
    changeShowUserForm(true, user);
  }
};

const userRole = computed(() => page.props.auth.user?.role);
const userId = computed(() => page.props.auth.user?.id);
</script>

<template>
  <MainLayout>
    <div class="p-6">
      <TitlePage title="Usuários" />
      <Separator class="my-4" />
      <div
        class="m-3 flex justify-end"
        v-if="userRole === 'super_admin' || userRole === 'admin'"
      >
        <Button
          class="cursor-pointer bg-black"
          @click="changeShowUserForm(true)"
        >
          Criar usuário
          <Plus />
        </Button>
      </div>
      <UsersTable :users="props.users" @edit:user="startEdit" />
    </div>
  </MainLayout>
  <!-- Modals -->
  <UserForm :data="showUserForm" @update:open="changeShowUserForm(false)" />
</template>

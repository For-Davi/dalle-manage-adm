<script setup lang="ts">
import { Separator } from '@/components/ui/separator';
import MainLayout from '@/layout/MainLayout.vue';
import TitlePage from '@/components/general/TitlePage.vue';
import UsersTable from '@/components/tables/UsersTable.vue';
import { reactive, watch } from 'vue';
import UserForm from '@/components/form/UserForm.vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Plus } from 'lucide-vue-next';

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

watch(
  () => page,
  () => {
    if (page.props.flash.success) {
      toast.success(page.props.flash.success);
    }
  },
  { immediate: true, deep: true }
);
</script>

<template>
  <MainLayout>
    <div class="p-6">
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
      <UsersTable :users="props.users" @edit:user="startEdit" />
    </div>
  </MainLayout>
  <!-- Modals -->
  <UserForm :data="showUserForm" @update:open="changeShowUserForm(false)" />
</template>

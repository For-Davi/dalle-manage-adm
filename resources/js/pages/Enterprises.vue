<script setup lang="ts">
import MainLayout from '@/layout/MainLayout.vue';
import EnterprisesTable from '@/components/tables/EnterprisesTable.vue';
import { Plus } from 'lucide-vue-next';
import EnterpriseForm from '@/components/form/EnterpriseForm.vue';
import { reactive } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import UserForm from '@/components/form/UserForm.vue';
import UsersEnterpriseManage from '@/components/manage/UsersEnterpriseManage.vue';

defineOptions({
  name: 'Enterprises',
});

const props = defineProps<{
  enterprises: IEnterprise[];
}>();

const page = usePage();

const currentEnterprise = reactive<{ enterprise: IEnterprise | null }>({
  enterprise: null,
});
const showEnterpriseForm = reactive<{
  open: boolean;
  enterprise: IEnterprise | null;
}>({
  open: false,
  enterprise: null,
});
const showUserForm = reactive<{
  open: boolean;
  user: IUser | null;
  enterprise: IEnterprise | null;
}>({
  open: false,
  user: null,
  enterprise: null,
});
const showUsersEnterpriseManage = reactive<{
  open: boolean;
  enterprise: IEnterprise | null;
}>({
  open: false,
  enterprise: null,
});

const changeShowUserEnterpriseManage = (
  show: boolean,
  enterprise: IEnterprise | null = null
): void => {
  Object.assign(showUsersEnterpriseManage, {
    open: show,
    enterprise: enterprise,
  });
};
const changeShowEnterpriseForm = (
  show: boolean,
  enterprise: IEnterprise | null = null
): void => {
  Object.assign(showEnterpriseForm, {
    open: show,
    enterprise: enterprise,
  });
};
const changeShowUserForm = (show: boolean, user: IUser | null = null): void => {
  Object.assign(showUserForm, {
    open: show,
    user: user,
  });
};
const startEdit = (enterprise: IEnterprise) => {
  changeShowEnterpriseForm(true, enterprise);
};
const addUser = (enterprise: IEnterprise) => {
  currentEnterprise.enterprise = enterprise;
  Object.assign(showUserForm, {
    open: true,
    user: null,
    enterprise: enterprise,
  });
};
const handleEditUser = (enterprise: IEnterprise, user: IUser) => {
  currentEnterprise.enterprise = enterprise;
  Object.assign(showUserForm, {
    open: true,
    user: user,
    enterprise: enterprise,
  });
};
const closeFormOpenManage = () => {
  changeShowUserForm(false);
  if (currentEnterprise.enterprise) {
    changeShowUserEnterpriseManage(true, currentEnterprise.enterprise);
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
      <TitlePage title="Empresas" />
      <Separator class="my-4" />
      <div class="m-3 flex justify-end">
        <Button
          class="cursor-pointer bg-black"
          @click="changeShowEnterpriseForm(true)"
        >
          Criar empresa
          <Plus />
        </Button>
      </div>
      <EnterprisesTable
        :enterprises="props.enterprises"
        @edit:enterprise="startEdit"
        @open:manage="
          (enterprise: IEnterprise) =>
            changeShowUserEnterpriseManage(true, enterprise)
        "
      />
    </div>
  </MainLayout>

  <!-- Modals -->
  <EnterpriseForm
    :data="showEnterpriseForm"
    @update:open="changeShowEnterpriseForm(false)"
  />
  <UserForm :data="showUserForm" @update:open="closeFormOpenManage" />
  <UsersEnterpriseManage
    :data="showUsersEnterpriseManage"
    @update:open="changeShowUserEnterpriseManage(false)"
    @add:user="(enterprise: IEnterprise) => addUser(enterprise)"
    @edit:user="
      (data: { enterprise: IEnterprise; user: IUser }) =>
        handleEditUser(data.enterprise, data.user)
    "
  />
  />
</template>

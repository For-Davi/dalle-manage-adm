<script setup lang="ts">
import EnterprisesTable from '@/components/tables/EnterprisesTable.vue';
import { Plus } from 'lucide-vue-next';
import EnterpriseForm from '@/components/form/EnterpriseForm.vue';
import { onMounted, reactive } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import UserForm from '@/components/form/UserForm.vue';
import UsersEnterpriseManage from '@/components/manage/UsersEnterpriseManage.vue';
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';

defineOptions({
  name: 'Enterprise',
});

const { loadingEnterprise, listEnterprises } =
  storeToRefs(useEnterpriseStore());

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
  user: IUserAdm | null;
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
const changeShowUserForm = (
  show: boolean,
  user: IUserAdm | null = null
): void => {
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
const handleEditUser = (enterprise: IEnterprise, user: IUserAdm) => {
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
const fetchEnterprises = async () => {
  await useEnterpriseStore().getEnterprises();
};

onMounted(async () => {
  await fetchEnterprises();
});
</script>

<template>
    <main>
        <div v-if="!loadingEnterprise">
            <div class="p-6">
              <TitlePage title="Empresas" />
              <Separator class="my-4" />
              <div class="m-3 flex justify-end">
                <Button
                  class="cursor-pointer bg-black"
                  @click="changeShowEnterpriseForm(true, null)"
                >
                  Criar empresa
                  <Plus />
                </Button>
              </div>
              <EnterprisesTable
                :enterprises="listEnterprises"
                @edit:enterprise="startEdit"
                @open:manage="
                  (enterprise: IEnterprise) =>
                    changeShowUserEnterpriseManage(true, enterprise)
                "
              />
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
                  (data: { enterprise: IEnterprise; user: IUserAdm }) =>
                    handleEditUser(data.enterprise, data.user)
                "
              />
            </div>
        </div>
        <div class="p-6" v-else>
          <Spinner  class="size-8" />
        </div>
    </main>
</template>

<script setup lang="ts">
import { reactive, onMounted, computed } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { validateUpdate } from './validation';
import { storeToRefs } from 'pinia';
import { goUrlName } from '@/composables/useRedirect';
import { useUserAdmStore } from '@/stores/user-adm-store';

defineOptions({
  name: 'UserEdit',
});

const props = defineProps<{
  id: string;
}>();

const { loadingUserAdm } = storeToRefs(useUserAdmStore());

const form = reactive({
  name: '' as string,
  email: '' as string,
});

const update = async () => {
  const status = validateUpdate(form);
  if (status.status) {
    const response = await useUserAdmStore().updateUser(Number(props.id), form);
    if (response?.status === 200) {
      await goUrlName('users');
    }
  }
};
const fetchUser = async () => {
  const response = await useUserAdmStore().showUserAdm(Number(props.id));
  if (response?.status === 200) {
    Object.assign(form, {
      name: response.data.user.name,
      email: response.data.user.email,
    });
  }
};
const clear = () => {
  Object.assign(form, {
    name: '',
    email: '',
  });
};

const actions = computed<IMenuAction[]>(() => [
  {
    label: 'Limpar formulário',
    type: 'button',
    variant: 'outline',
    onClick: clear,
    disabled: loadingUserAdm.value,
  },
  {
    label: loadingUserAdm.value ? 'Atualizando...' : 'Atualizar Usuário',
    type: 'submit',
    class: 'px-8',
    disabled: loadingUserAdm.value,
    loading: loadingUserAdm.value,
  },
]);
const breadcrumbItems = computed<IBreadcrumbItem[]>(() => [
  {
    label: 'Usuários',
    to: { name: 'users' },
  },
  {
    label: 'Edição',
  },
])

onMounted(async () => {
  clear();
  fetchUser();
});
</script>
<template>
  <main class="bg-slate-50/50 p-4 md:p-8">
    <div v-if="!loadingUserAdm">
      <div class="mb-2">
        <TitlePage title="Cadastro de usuário" />
        <p class="text-muted-foreground mt-1 text-sm">
          <b>Dalle Manage ADM</b> - Atualize as informações de um usuário na
          administração.
        </p>
      </div>
      <Separator class="my-2" />
      <AppBreadcrumb :items="breadcrumbItems" />
      <form @submit.prevent="update" class="space-y-6">
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Dados do usuário</CardTitle>
          </CardHeader>
          <CardContent class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2 md:col-span-2">
              <Label for="name">Nome do usuário</Label>
              <Input
                v-model="form.name"
                id="name"
                placeholder="Ex: Carlos Davi"
              />
            </div>
            <div class="space-y-2">
              <Label for="email">E-mail</Label>
              <Input
                v-model="form.email"
                type="email"
                id="email"
                placeholder="contato@empresa.com"
              />
            </div>
          </CardContent>
        </Card>
        <MenuActions :actions="actions" />
      </form>
    </div>
    <div v-else class="flex h-[50vh] items-center justify-center">
      <Spinner class="size-10" />
    </div>
  </main>
</template>

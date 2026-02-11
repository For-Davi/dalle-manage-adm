<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { validateCreate } from './validation';
import { storeToRefs } from 'pinia';
import { goUrlName } from '@/composables/useRedirect';
import { useUserAdmStore } from '@/stores/user-adm-store';

defineOptions({
  name: 'UserCreate',
});

const props = defineProps<{
  id: string;
}>();

const { loadingUserAdm } = storeToRefs(useUserAdmStore());

const form = reactive({
  name: '' as string,
  email: '' as string,
  password: '' as string,
});
const confirmPassword = ref<string>('');

const create = async () => {
  const status = validateCreate({
    ...form,
    confirmPassword: confirmPassword.value,
  });
  if (status.status) {
    const response = await useUserAdmStore().createUser(form);
    if (response?.status === 201) {
      await goUrlName('users');
    }
  }
};
const clear = () => {
  Object.assign(form, {
    name: '',
    email: '',
    password: '',
  });
  confirmPassword.value = '';
};

onMounted(async () => {
  clear();
});
</script>
<template>
  <main class="bg-slate-50/50 p-4 md:p-8">
    <div v-if="!loadingUserAdm">
      <div class="mb-2">
        <TitlePage title="Cadastro de usuário" />
        <p class="text-muted-foreground mt-1 text-sm">
          <b>Dalle Manage ADM</b> - Preencha as informações abaixo para
          cadastrar um novo usuário na administração.
        </p>
      </div>
      <Separator class="my-2" />
      <Breadcrumb class="mb-4">
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink class="cursor-pointer" as-child>
              <RouterLink :to="{ name: 'users' }"> Usuários </RouterLink>
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbLink class="font-bold"> Cadastro </BreadcrumbLink>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
      <form @submit.prevent="create" class="space-y-6">
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
            <div class="space-y-2">
              <Label for="password" class="ml-1 font-bold">Senha</Label>
              <Input
                v-model="form.password"
                type="password"
                id="password"
                autocomplete="new-password"
                placeholder="Insira a senha"
              />
            </div>
            <div class="space-y-2">
              <Label for="confirmPassword" class="ml-1 font-bold"
                >Confirme a senha</Label
              >
              <Input
                v-model="confirmPassword"
                type="password"
                id="confirmPassword"
                autocomplete="new-password"
                placeholder="Confirme a senha"
              />
            </div>
          </CardContent>
        </Card>
        <div class="mt-8 flex items-center justify-end gap-4">
          <Button type="button" variant="outline" @click="clear"
            >Limpar formulário</Button
          >
          <Button type="submit" class="px-8" :disabled="loadingUserAdm">
            <LucideLoader2
              v-if="loadingUserAdm"
              class="mr-2 h-4 w-4 animate-spin"
            />
            {{ loadingUserAdm ? 'Salvando...' : 'Cadastrar Usuário' }}
          </Button>
        </div>
      </form>
    </div>
    <div v-else class="flex h-[50vh] items-center justify-center">
      <Spinner class="size-10" />
    </div>
  </main>
</template>

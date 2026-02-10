<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { validateCreate } from './validation';
import { storeToRefs } from 'pinia';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { goUrlName } from '@/composables/useRedirect';

defineOptions({
  name: 'UserCreate',
});

const props = defineProps<{
  id: string;
}>();

const { loadingEnterprise } = storeToRefs(useEnterpriseStore());

const form = reactive({
  name: '' as string,
  email: '' as string,
  password: '' as string,
  createEmployee: false as boolean,
});
const confirmPassword = ref<string>('');
const entepriseName = ref<string>('');

const create = async () => {
  const status = validateCreate({
    ...form,
    confirmPassword: confirmPassword.value,
  });
  if (status.status) {
    const response = await useEnterpriseStore().createUserByEnterprise(
      form,
      Number(props.id)
    );
    if (response?.status === 201) {
      await goUrlName('enterprise-users', { id: props.id });
    }
  }
};
const fetchNameEnterprise = async () => {
  const response = await useEnterpriseStore().showEnterprise(Number(props.id));
  if (response?.status === 200) {
    entepriseName.value = response.data.enterprise.name;
  }
};
const clear = () => {
  Object.assign(form, {
    name: '',
    email: '',
    password: '',
    createEmployee: false,
  });
  confirmPassword.value = '';
};

onMounted(async () => {
  clear();
  fetchNameEnterprise();
});
</script>
<template>
  <main class="bg-slate-50/50 p-4 md:p-8">
    <div v-if="!loadingEnterprise">
      <div class="mb-2">
        <TitlePage title="Cadastro de usuário" />
        <p class="text-muted-foreground mt-1 text-sm">
          <b>{{ entepriseName }}</b> - Preencha as informações abaixo para
          cadastrar um novo usuário na organização.
        </p>
      </div>
      <Separator class="my-2" />
      <Breadcrumb class="mb-4">
        <BreadcrumbList>
          <BreadcrumbItem>
            <BreadcrumbLink class="cursor-pointer" as-child>
              <RouterLink :to="{ name: 'enterprises' }"> Empresas </RouterLink>
            </BreadcrumbLink>
          </BreadcrumbItem>
          <BreadcrumbSeparator />
          <BreadcrumbItem>
            <BreadcrumbLink class="cursor-pointer" as-child>
              <RouterLink
                :to="{ name: 'enterprise-users', params: { id: props.id } }"
              >
                Usuários
              </RouterLink>
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
              <Label for="switchChangePassword" class="ml-1 font-bold"
                >Cadastrar como funcionário?</Label
              >
              <Switch
                v-model="form.createEmployee"
                id="switchCreateEmployee"
                class="ml-1 cursor-pointer"
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
          <Button type="submit" class="px-8" :disabled="loadingEnterprise">
            <LucideLoader2
              v-if="loadingEnterprise"
              class="mr-2 h-4 w-4 animate-spin"
            />
            {{ loadingEnterprise ? 'Salvando...' : 'Cadastrar Usuário' }}
          </Button>
        </div>
      </form>
    </div>
    <div v-else class="flex h-[50vh] items-center justify-center">
      <Spinner class="size-10" />
    </div>
  </main>
</template>

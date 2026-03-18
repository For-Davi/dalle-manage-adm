<script setup lang="ts">
import { reactive, onMounted, computed } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { validateCreateOrUpdate } from './validation';
import { storeToRefs } from 'pinia';
import { goUrlName } from '@/composables/useRedirect';
import { useSellerStore } from '@/stores/seller-store';

defineOptions({
  name: 'SellerCreate',
});

const { loadingSeller } = storeToRefs(useSellerStore());

const form = reactive({
  name: '' as string,
  email: '' as string,
  phone: '' as string,
  code: '' as string,
  commission: '0' as string,
});

const create = async () => {
  const status = validateCreateOrUpdate(form);
  if (status.status) {
    const response = await useSellerStore().createSeller({
      ...form,
      commission: Number(form.commission),
    });
    if (response?.status === 201) {
      goUrlName('sellers');
    }
  }
};
const clear = () => {
  Object.assign(form, {
    name: '',
    email: '',
    phone: '',
    code: '',
    commission: '0',
  });
};

const actions = computed<IMenuAction[]>(() => [
  {
    label: 'Limpar formulário',
    variant: 'outline',
    type: 'button',
    onClick: clear,
  },
  {
    label: loadingSeller.value ? 'Salvando...' : 'Cadastrar Vendedor',
    type: 'submit',
    class: 'px-8',
    disabled: loadingSeller.value,
    loading: loadingSeller.value,
    icon: 'LucidePlus',
  },
]);
const breadcrumbItems = computed<IBreadcrumbItem[]>(() => [
  {
    label: 'Vendedores',
    to: { name: 'sellers' },
  },
  {
    label: 'Cadastro',
  },
]);

onMounted(async () => {
  clear();
});
</script>
<template>
  <main class="bg-slate-50/50 p-4 md:p-8">
    <div v-if="!loadingSeller">
      <div class="mb-2">
        <TitlePage title="Cadastro de vendedor" />
        <p class="text-muted-foreground mt-1 text-sm">
          <b>Dalle Manage ADM</b> - Preencha as informações abaixo para
          cadastrar um novo vendedor.
        </p>
      </div>
      <Separator class="my-2" />
      <AppBreadcrumb :items="breadcrumbItems" />
      <form @submit.prevent="create" class="space-y-6">
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Dados do vendedor</CardTitle>
          </CardHeader>
          <CardContent class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2 md:col-span-2">
              <Label for="name">Nome do vendedor</Label>
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
            <div class="mb-2 space-y-2">
              <Label for="phone" class="ml-1 font-bold">Telefone</Label>
              <Input
                v-model="form.phone"
                type="name"
                id="phone"
                placeholder="(99) 99999-9999"
                autocomplete="new-name"
              />
            </div>
            <div class="mb-2 space-y-2">
              <Label for="commission" class="ml-1 font-bold">Comissão %</Label>
              <Input
                v-model="form.commission"
                type="text"
                id="commission"
                placeholder="Insira a comissão do(a) vendedor(a)"
                autocomplete="new-commission"
              />
            </div>
            <div class="mb-2 space-y-2">
              <Label for="code" class="ml-1 font-bold">Código</Label>
              <Input
                v-model="form.code"
                type="name"
                id="code"
                placeholder="Insira o código do(a) vendedor(a)"
                autocomplete="new-name"
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

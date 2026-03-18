<script setup lang="ts">
import { reactive, onMounted, computed, watch } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { storeToRefs } from 'pinia';
import { goUrlName } from '@/composables/useRedirect';
import { useSellerStore } from '@/stores/seller-store';
import { validateCreateOrUpdate } from './validation';

defineOptions({
  name: 'SellerEdit',
});

const props = defineProps<{
  id: string;
}>();

const { loadingSeller } = storeToRefs(useSellerStore());

const form = reactive({
  name: '' as string,
  email: '' as string,
  phone: '' as string,
  code: '' as string,
  commission: '0' as string,
});

const update = async () => {
  const status = validateCreateOrUpdate(form);
  if (status.status) {
    const response = await useSellerStore().updateSeller(Number(props.id), {
      ...form,
      commission: Number(form.commission),
    });
    if (response?.status === 200) {
      goUrlName('sellers');
    }
  }
};
const fetchSeller = async () => {
  const response = await useSellerStore().showSeller(Number(props.id));
  if (response?.status === 200) {
    Object.assign(form, {
      name: response.data.seller.name,
      email: response.data.seller.email,
      phone: response.data.seller.phone ?? '',
      code: response.data.seller.code ?? '',
      comission: String(response.data.seller.commission) ?? '',
    });
  }
};
const clear = () => {
  Object.assign(form, {
    name: '',
    email: '',
    phone: '',
    code: '',
    comission: '0',
  });
};

const actions = computed<IMenuAction[]>(() => [
  {
    label: 'Limpar formulário',
    type: 'button',
    variant: 'outline',
    onClick: clear,
    disabled: loadingSeller.value,
  },
  {
    label: loadingSeller.value ? 'Atualizando...' : 'Atualizar Vendedor',
    type: 'submit',
    class: 'px-8',
    disabled: loadingSeller.value,
    loading: loadingSeller.value,
  },
]);
const breadcrumbItems = computed<IBreadcrumbItem[]>(() => [
  {
    label: 'Vendedores',
    to: { name: 'sellers' },
  },
  {
    label: 'Edição',
  },
]);

onMounted(async () => {
  clear();
  fetchSeller();
});
</script>
<template>
  <main class="bg-slate-50/50 p-4 md:p-8">
    <div v-if="!loadingSeller">
      <div class="mb-2">
        <TitlePage title="Atualização de vendedor" />
        <p class="text-muted-foreground mt-1 text-sm">
          <b>Dalle Manage ADM</b> - Atualize as informações de um vendedor na
          administração.
        </p>
      </div>
      <Separator class="my-2" />
      <AppBreadcrumb :items="breadcrumbItems" />
      <form @submit.prevent="update" class="space-y-6">
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
                type="number"
                id="commission"
                placeholder="Insira a comissão do(a) vendedor(a)"
                autocomplete="off"
              />
            </div>
            <div class="mb-2 space-y-2">
              <Label for="code" class="ml-1 font-bold">Código</Label>
              <Input
                v-model="form.code"
                type="text"
                id="code"
                placeholder="Insira o código do(a) vendedor(a)"
                autocomplete="off"
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

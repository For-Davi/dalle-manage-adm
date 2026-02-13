<script setup lang="ts">
import { watch, ref, reactive, onMounted, computed } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { storeToRefs } from 'pinia';
import { searchCep } from '@/services/cep-service';
import { useSellerStore } from '@/stores/seller-store';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { useSubscriptionStore } from '@/stores/subscription-store';
import { validateCreateorUpdate } from './validation';
import router from '@/router';
import { goUrlName } from '@/composables/useRedirect';
import { getNameSubscription } from '@/composables/useSubscription';

defineOptions({
  name: 'EnterpriseEdit',
});

const props = defineProps<{
  id: string;
}>();

const { loadingSeller, listSellers } = storeToRefs(useSellerStore());
const { loadingSubscription, listSubscriptions } = storeToRefs(
  useSubscriptionStore()
);
const { loadingEnterprise } = storeToRefs(useEnterpriseStore());

const allowSearchCep = ref<boolean>(false);
const loading = ref<boolean>(false);
const loadingCep = ref<boolean>(false);
const type = ref<'cnpj' | 'cpf'>('cnpj');
const form = reactive({
  name: '' as string,
  email: '' as string,
  phone: '' as string,
  cpf: '' as string,
  cnpj: '' as string,
  cep: '' as string,
  state: '' as string,
  city: '' as string,
  neighborhood: '' as string,
  address: '' as string,
  numberAddress: '' as string,
  complement: '' as string,
  active: 1 as number,
  sellerID: null as number | null,
  subscriptionID: 0 as number,
});

const update = async () => {
  const status = validateCreateorUpdate(form);
  if (status.status) {
    const response = await useEnterpriseStore().updateEnterprise(form);
    if (response?.status === 200) {
      await router.push({ name: 'enterprises' });
    }
  }
};
const clear = () => {
  Object.assign(form, {
    name: '',
    email: '',
    phone: '',
    cpf: '',
    cnpj: '',
    cep: '',
    state: '',
    city: '',
    neighborhood: '',
    address: '',
    numberAddress: '',
    complement: '',
    active: 1,
    subscriptionID: 0,
    sellerID: null,
  });
  allowSearchCep.value = false;
};
const setLoading = (value: boolean) => {
  loading.value = value;
};
const setLoadingCep = (value: boolean) => {
  loadingCep.value = value;
};
const fetchEnterprise = async () => {
  loadingCep.value = false;
  const response = await useEnterpriseStore().showEnterprise(Number(props.id));
  if (response?.status === 200) {
    const enterprise = response.data.enterprise;

    Object.assign(form, {
      name: enterprise.name ?? '',
      email: enterprise.email ?? '',
      phone: enterprise.phone ?? '',
      cpf: enterprise.cpf ?? '',
      cnpj: enterprise.cnpj ?? '',
      cep: enterprise.cep ?? '',
      state: enterprise.state ?? '',
      city: enterprise.city ?? '',
      neighborhood: enterprise.neighborhood ?? '',
      address: enterprise.address ?? '',
      numberAddress: enterprise.number_address ?? '',
      complement: enterprise.complement ?? '',
      active: enterprise.active,
      subscriptionID: enterprise.subscription_id,
      sellerID: enterprise.seller_id,
    });
  } else {
    goUrlName('enterprises');
  }
};

const actions = computed<IMenuAction[]>(() => [
  {
    label: 'Resetar formulário',
    type: 'button',
    variant: 'outline',
    onClick: fetchEnterprise,
    disabled: loadingEnterprise.value,
  },
  {
    label: loadingEnterprise.value ? 'Carregando...' : 'Atualizar Empresa',
    type: 'submit',
    class: 'px-8',
    disabled: loadingEnterprise.value,
    loading: loadingEnterprise.value,
  },
]);
const breadcrumbItems = computed<IBreadcrumbItem[]>(() => [
  {
    label: 'Empresas',
    to: { name: 'enterprises' },
  },
  {
    label: 'Edição',
  },
])

watch(
  () => type.value,
  (type) => {
    if (type === 'cpf') {
      form.cnpj = '';
    } else {
      form.cpf = '';
    }
  }
);
watch(
  () => form.cep,
  async (cep: string) => {
    if (cep !== null && allowSearchCep.value) {
      form.cep = form.cep.replace(/\D/g, '');
      if (cep.trim().length === 8) {
        setLoadingCep(true);
        const response = await searchCep(cep);
        if (response.status === 200) {
          form.neighborhood = response.data.bairro;
          form.state = response.data.estado;
          form.city = response.data.localidade;
          form.address = response.data.logradouro;
        }
      }
      setLoadingCep(false);
      allowSearchCep.value = true;
    }
  }
);

onMounted(async () => {
  clear();
  setLoading(true);
  await useSellerStore().getSellers();
  await useSubscriptionStore().getSubscriptions();
  await fetchEnterprise();
  setLoading(false);
});
</script>

<template>
  <main class="bg-slate-50/50 p-4 md:p-8">
    <div v-if="!loading">
      <div class="mb-2">
        <TitlePage title="Edição de Empresa" />
        <p class="text-muted-foreground mt-1 text-sm">
          Preencha as informações abaixo para cadastrar uma nova organização.
        </p>
      </div>
      <Separator class="my-2" />
      <AppBreadcrumb :items="breadcrumbItems" />
      <form @submit.prevent="update" class="space-y-6">
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Informações Gerais</CardTitle>
          </CardHeader>
          <CardContent class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2 md:col-span-2">
              <Label for="name">Nome da Empresa</Label>
              <Input
                v-model="form.name"
                id="name"
                placeholder="Ex: Tech Solutions Ltda"
              />
            </div>

            <div class="space-y-2">
              <Label for="email">E-mail Corporativo</Label>
              <Input
                v-model="form.email"
                type="email"
                id="email"
                placeholder="contato@empresa.com"
              />
            </div>

            <div class="space-y-2">
              <Label for="phone">Telefone</Label>
              <Input
                v-model="form.phone"
                id="phone"
                placeholder="(99) 99999-9999"
              />
            </div>

            <div class="space-y-2">
              <Label>Tipo de Documento</Label>
              <Select v-model="type">
                <SelectTrigger>
                  <SelectValue placeholder="Selecione" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="cnpj">CNPJ</SelectItem>
                  <SelectItem value="cpf">CPF</SelectItem>
                </SelectContent>
              </Select>
            </div>

            <div class="space-y-2">
              <Label :for="type">{{ type.toUpperCase() }}</Label>
              <Input
                v-if="type === 'cnpj'"
                v-model="form.cnpj"
                id="cnpj"
                placeholder="0000000000000"
                maxlength="14"
              />
              <Input
                v-else
                v-model="form.cpf"
                id="cpf"
                placeholder="00000000000"
                maxlength="11"
              />
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Endereço</CardTitle>
          </CardHeader>
          <CardContent class="grid gap-4 md:grid-cols-3">
            <div class="relative space-y-2">
              <Label for="cep">CEP</Label>
              <div class="relative">
                <Input
                  v-model="form.cep"
                  id="cep"
                  placeholder="00000-000"
                  maxlength="9"
                  :disabled="loadingCep"
                />
                <LucideLoader2
                  v-if="loadingCep"
                  class="text-muted-foreground absolute top-2.5 right-3 h-4 w-4 animate-spin"
                />
              </div>
            </div>

            <div class="space-y-2 md:col-span-1">
              <Label for="state">Estado</Label>
              <Input v-model="form.state" id="state" placeholder="UF" />
            </div>

            <div class="space-y-2 md:col-span-1">
              <Label for="city">Cidade</Label>
              <Input v-model="form.city" id="city" placeholder="Cidade" />
            </div>
            <div class="space-y-2 md:col-span-2">
              <Label for="neighborhood">Bairro</Label>
              <Input v-model="form.neighborhood" id="neighborhood" />
            </div>

            <div class="space-y-2 md:col-span-1">
              <Label for="address">Logradouro</Label>
              <Input v-model="form.address" id="address" />
            </div>

            <div class="space-y-2">
              <Label for="numberAddress">Número</Label>
              <Input v-model="form.numberAddress" id="numberAddress" />
            </div>

            <div class="space-y-2 md:col-span-2">
              <Label for="complement">Complemento</Label>
              <Input
                v-model="form.complement"
                id="complement"
                placeholder="Sala, andar, bloco..."
              />
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Assinatura e Vendas</CardTitle>
          </CardHeader>
          <CardContent class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
              <Label>Assinatura</Label>
              <Select v-model="form.subscriptionID">
                <SelectTrigger>
                  <SelectValue placeholder="Selecione um plano" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem
                    v-for="(value, index) in listSubscriptions"
                    :value="value.id"
                    :key="index"
                    >{{ getNameSubscription(value.name) }}</SelectItem
                  >
                </SelectContent>
              </Select>
            </div>

            <div class="space-y-2">
              <Label>Vendedor</Label>
              <Select v-model="form.sellerID">
                <SelectTrigger>
                  <SelectValue placeholder="Selecione um vendedor" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem :value="null">Nenhum</SelectItem>
                  <SelectItem
                    v-for="seller in listSellers"
                    :key="seller.id"
                    :value="seller.id"
                  >
                    {{ seller.name }}
                  </SelectItem>
                </SelectContent>
              </Select>
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

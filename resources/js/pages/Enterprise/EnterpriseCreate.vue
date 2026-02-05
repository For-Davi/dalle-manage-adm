<script setup lang="ts">
import { watch, ref, reactive, onMounted } from 'vue';
import TitlePage from '@/components/general/TitlePage.vue';
import { storeToRefs } from 'pinia';
import { searchCep } from '@/services/cep-service';
import { useSellerStore } from '@/stores/seller-store';
import { useEnterpriseStore } from '@/stores/enterprise-store';
import { validateCreate } from './validation';
import router from '@/router';

defineOptions({
  name: 'EnterpriseCreate',
});

const { loadingSeller, listSellers } = storeToRefs(useSellerStore());
const { loadingEnterprise } = storeToRefs(useEnterpriseStore());

const loading = ref<boolean>(false);
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
  subscriptionID: 1 as number,
  sellerID: null as number | null,
  active: 1 as number,
});

const create = async () => {
  const status = validateCreate(form);
  if (status.status) {
    const response = await useEnterpriseStore().createEnterprise(form);
    if (response?.status === 201) {
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
    subscriptionID: '',
    sellerID: '',
    active: 1,
  });
};

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
    if (cep !== null) {
      form.cep = form.cep.replace(/\D/g, '');
      if (cep.trim().length === 8) {
        loading.value = true;
        const response = await searchCep(cep);
        if (response.status === 200) {
          form.neighborhood = response.data.bairro;
          form.state = response.data.estado;
          form.city = response.data.localidade;
          form.address = response.data.logradouro;
        }
      } else {
        form.neighborhood = '';
        form.state = '';
        form.city = '';
        form.address = '';
      }
      loading.value = false;
    }
  }
);

const fetchSellers = async () => {
  await useSellerStore().getSellers();
};

onMounted(async () => {
  clear();
  await fetchSellers();
});
</script>

<template>
  <main class="bg-slate-50/50 p-4 md:p-8">
    <div v-if="!loadingEnterprise && !loadingSeller" class=" ">
      <div class="mb-2">
        <TitlePage title="Registro de Empresa" />
        <p class="text-muted-foreground mt-1 text-sm">
          Preencha as informações abaixo para cadastrar uma nova organização.
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
            <BreadcrumbLink class="cursor-pointer font-bold">
              Cadastro
            </BreadcrumbLink>
          </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
      <form @submit.prevent="create" class="space-y-6">
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
                  :disabled="loading"
                />
                <LucideLoader2
                  v-if="loading"
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
              <Label>Plano de Assinatura</Label>
              <Select v-model="form.subscriptionID">
                <SelectTrigger>
                  <SelectValue placeholder="Selecione um plano" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem :value="1">Grátis</SelectItem>
                  <SelectItem :value="2">Básica</SelectItem>
                  <SelectItem :value="3">Premium</SelectItem>
                </SelectContent>
              </Select>
            </div>

            <div class="space-y-2">
              <Label>Vendedor Responsável</Label>
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

        <div class="mt-8 flex items-center justify-end gap-4">
          <Button type="button" variant="outline" @click="clear"
            >Limpar formulário</Button
          >
          <Button type="submit" class="px-8" :disabled="loadingEnterprise">
            <LucideLoader2
              v-if="loadingEnterprise"
              class="mr-2 h-4 w-4 animate-spin"
            />
            {{ loadingEnterprise ? 'Salvando...' : 'Cadastrar Empresa' }}
          </Button>
        </div>
      </form>
    </div>
    <div v-else class="flex h-[50vh] items-center justify-center">
      <Spinner class="size-10" />
    </div>
  </main>
</template>

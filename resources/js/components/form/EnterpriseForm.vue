<script setup lang="ts">
import { computed, watch, ref } from 'vue';
import TitlePage from '../general/TitlePage.vue';
import { useForm } from '@inertiajs/vue3';
import { phoneValidation } from '@/composables/PhoneValidation';
import { searchCep } from '@/services/cep-service';

defineOptions({
  name: 'EnterpriseForm',
});

const emit = defineEmits<{
  'update:open': [void];
}>();

const props = defineProps<{
  data: {
    open: boolean;
    enterprise: IEnterprise;
    sellers: ISeller[];
  };
}>();

const loading = ref<boolean>(false);
const allowSearchCep = ref<boolean>(false);
const type = ref<'cnpj' | 'cpf'>('cnpj');
const form = useForm({
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
  subscriptionId: '',
  sellerID: '',
  active: 1,
});

const create = () => {
  form.post(route('enterprise.create'), {
    onSuccess: () => emit('update:open'),
  });
};
const update = () => {
  form.put(route('enterprise.update', props.data.enterprise?.id), {
    onSuccess: () => emit('update:open'),
  });
};
const clear = () => {
  form.name = '';
  form.email = '';
  form.phone = '';
  form.cpf = '';
  form.cnpj = '';
  form.cep = '';
  form.state = '';
  form.city = '';
  form.neighborhood = '';
  form.address = '';
  form.numberAddress = '';
  form.complement = '';
  form.subscriptionId = '';
  form.sellerID = '';
  form.clearErrors();
};
const checkDataEdit = () => {
  if (props.data.enterprise) {
    Object.assign(form, {
      name: props.data.enterprise.name,
      email: props.data.enterprise.email,
      phone: props.data.enterprise.phone,
      cpf: props.data.enterprise.cpf,
      cnpj: props.data.enterprise.cnpj,
      cep: props.data.enterprise.cep,
      state: props.data.enterprise.state,
      city: props.data.enterprise.city,
      neighborhood: props.data.enterprise.neighborhood,
      address: props.data.enterprise.address,
      numberAddress: props.data.enterprise.number_address,
      complement: props.data.enterprise.complement,
      subscriptionId: props.data.enterprise.subscription_id,
      sellerID: props.data.enterprise.seller_id,
      active: props.data.enterprise.active,
    });
  }
  type.value = props.data.enterprise?.cpf ? 'cpf' : 'cnpj';
};

const open = computed({
  get: () => props.data.open,
  set: () => emit('update:open'),
});

watch(
  () => form.phone,
  (value: string) => {
    if (value !== null) {
      const errorMessage = phoneValidation(value);
      if (errorMessage) {
        form.errors.phone = errorMessage;
      } else {
        delete form.errors.phone;
      }
    }
  }
);
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
      if (allowSearchCep.value) {
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
      } else {
        allowSearchCep.value = true;
      }
      loading.value = false;
    }
  }
);
watch(open, () => {
  if (open.value) {
    clear();
    checkDataEdit();
  }
});
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent
      class="h-[700px] max-h-[90vh] w-[900px] max-w-[90vw] overflow-auto p-4"
    >
      <DialogHeader>
        <DialogTitle>
          <TitlePage
            :title="
              props.data.enterprise
                ? 'Edição de empresa'
                : 'Registro de empresa'
            "
            icon="Building2"
          />
        </DialogTitle>
        <Separator class="my-1 bg-gray-500" />
      </DialogHeader>
      <form @submit.prevent="props.data.enterprise ? update() : create()">
        <div class="mb-2 space-y-2">
          <Label for="name" class="ml-1 font-bold">Nome da empresa</Label>
          <Input
            v-model="form.name"
            type="name"
            id="name"
            placeholder="Insira o nome da empresa"
          />
        </div>
        <div class="mb-2 space-y-2">
          <Label for="email" class="ml-1 font-bold">Email da empresa</Label>
          <Input
            v-model="form.email"
            type="email"
            id="email"
            placeholder="Insira o email da empresa"
          />
        </div>
        <div class="mb-2 space-y-2">
          <Label for="phone" class="ml-1 font-bold">Telefone da empresa</Label>
          <Input
            v-model="form.phone"
            type="tel"
            id="phone"
            placeholder="(99) 99999-9999"
          />
        </div>
        <div class="mb-1 flex justify-between gap-2 space-y-1">
          <div class="mb-2 w-full space-y-2">
            <Label for="choice" class="ml-1 font-bold">Escolha um tipo</Label>
            <Select id="choice" v-model="type">
              <SelectTrigger class="w-full cursor-pointer">
                <SelectValue placeholder="Selecione um tipo" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectItem class="cursor-pointer" value="cnpj">
                    CNPJ
                  </SelectItem>
                  <SelectItem class="cursor-pointer" value="cpf">
                    CPF
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>
          </div>
          <div class="mb-2 w-full space-y-2">
            <Label
              :for="type === 'cnpj' ? 'cnpj' : 'cpf'"
              class="ml-1 font-bold"
              >{{ type === 'cnpj' ? 'CNPJ' : 'CPF' }}</Label
            >
            <Input
              v-if="type === 'cnpj'"
              v-model="form.cnpj"
              type="tel"
              id="cnpj"
              placeholder="CNPJ"
              maxlength="14"
            />
            <Input
              v-else
              v-model="form.cpf"
              id="cpf"
              placeholder="CPF"
              maxlength="11"
            />
          </div>
        </div>
        <div class="mb-2 space-y-2">
          <Label for="cep" class="ml-1 font-bold">CEP</Label>
          <Input
            v-model="form.cep"
            id="cep"
            placeholder="Insira o CEP da empresa"
          >
            <div
              v-if="loading"
              class="absolute top-1/2 right-3 -translate-y-1/2"
            >
              <Loader2 class="h-4 w-4 animate-spin" />
            </div>
          </Input>
        </div>
        <div class="flex justify-between gap-2">
          <div class="mb-2 w-full space-y-2">
            <Label for="state" class="ml-1 font-bold">Estado</Label>
            <Input
              v-model="form.state"
              id="state"
              placeholder="Insira o estado da empresa"
            />
          </div>
          <div class="mb-2 w-full space-y-2">
            <Label for="city" class="ml-1 font-bold">Cidade</Label>
            <Input
              v-model="form.city"
              id="city"
              placeholder="Insira a cidade da empresa"
            />
          </div>
        </div>
        <div class="mb-2 space-y-2">
          <Label for="neighborhood" class="ml-1 font-bold">Bairro</Label>
          <Input
            v-model="form.neighborhood"
            id="neighborhood"
            placeholder="Insira o bairro da empresa"
          />
        </div>
        <div class="mb-2 space-y-2">
          <Label for="address" class="ml-1 font-bold">Logradouro</Label>
          <Input
            v-model="form.address"
            id="address"
            placeholder="Insira o logradouro da empresa"
          />
        </div>
        <div class="flex justify-between gap-2">
          <div class="w-full space-y-2">
            <Label for="numberAddress" class="ml-1 font-bold">Número</Label>
            <Input
              v-model="form.numberAddress"
              id="numberAddress"
              placeholder="Insira o número"
            />
          </div>
          <div class="w-full space-y-2">
            <Label for="complement" class="ml-1 font-bold">Complemento</Label>
            <Input
              v-model="form.complement"
              id="complement"
              placeholder="Insira o complemento"
            />
          </div>
        </div>
        <div class="mt-2 w-full space-y-2">
          <Label for="subscription" class="ml-1 font-bold"
            >Escolha uma assinatura</Label
          >
          <Select id="subscription" v-model="form.subscriptionId">
            <SelectTrigger class="w-full cursor-pointer">
              <SelectValue placeholder="Selecione um tipo de assinatura" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem class="cursor-pointer" :value="1">
                  Grátis
                </SelectItem>
                <SelectItem class="cursor-pointer" :value="2">
                  Básica
                </SelectItem>
                <SelectItem class="cursor-pointer" :value="3">
                  Premium
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        <div class="mb-2 space-y-2">
          <Label for="code" class="ml-1 font-bold">Escolha um vendedor</Label>
          <Select id="code" v-model="form.sellerID">
            <SelectTrigger class="w-full cursor-pointer">
              <SelectValue placeholder="Selecione um vendedor" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem class="cursor-pointer" :value="null">
                  Nenhum
                </SelectItem>
                <SelectItem
                  v-for="(seller, index) in props.data.sellers"
                  :key="index"
                  class="cursor-pointer"
                  :value="seller.id"
                >
                  {{ seller.name }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        <div class="mt-2 w-full space-y-2" v-if="props.data.enterprise">
          <Label for="active" class="ml-1 font-bold"
            >Escolha o status da empresa</Label
          >
          <Select id="active" v-model="form.active">
            <SelectTrigger class="w-full cursor-pointer">
              <SelectValue placeholder="Selecione o status da empresa" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem class="cursor-pointer" :value="1">
                  Ativo
                </SelectItem>
                <SelectItem class="cursor-pointer" :value="0">
                  Inativo
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        <div
          class="mt-2 ml-1 text-sm font-bold text-red-600"
          v-if="
            form.errors.name ||
            form.errors.email ||
            form.errors.phone ||
            form.errors.cpf ||
            form.errors.cnpj ||
            form.errors.cep ||
            form.errors.state ||
            form.errors.city ||
            form.errors.neighborhood ||
            form.errors.address ||
            form.errors.numberAddress ||
            form.errors.complement ||
            form.errors.subscriptionId ||
            form.errors.sellerID
          "
        >
          {{
            form.errors.name ||
            form.errors.email ||
            form.errors.phone ||
            form.errors.cpf ||
            form.errors.cnpj ||
            form.errors.cep ||
            form.errors.state ||
            form.errors.city ||
            form.errors.neighborhood ||
            form.errors.address ||
            form.errors.numberAddress ||
            form.errors.complement ||
            form.errors.subscriptionId ||
            form.errors.sellerID ||
            form.errors
          }}
        </div>
        <div class="mt-3 w-full">
          <Button class="w-full cursor-pointer">
            <div v-if="form.processing">
              <Loader2 class="mr-2 h-4 w-4 animate-spin" />
            </div>
            <div v-else>{{ props.data.enterprise ? 'Salvar' : 'Criar' }}</div>
          </Button>
        </div>
      </form>
    </DialogContent>
  </Dialog>
</template>

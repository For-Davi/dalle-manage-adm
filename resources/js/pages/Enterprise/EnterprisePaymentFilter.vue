<script setup lang="ts">
import TitlePage from '@/components/general/TitlePage.vue';
import { computed, reactive, ref, watch } from 'vue';

defineOptions({
  name: 'EnterprisePaymentFilter',
});

const props = defineProps<{
  open: boolean;
  filter: IFilterEnterprisePayment;
}>();
const emit = defineEmits<{
  'update:open': ['close' | IFilterEnterprisePayment];
}>();

const dataEnterprisePayment = reactive({
  startDate: '',
  endDate: '',
  enterprise: '',
  status: null,
});
const listStatus = ref([
  {
    name: 'Pago',
    value: 'CONFIRMED',
  },
  {
    name: 'Pendente',
    value: 'PENDING',
  },
]);

const send = () => {
  emit('update:open', dataEnterprisePayment);
};
const clear = () => {
  Object.assign(dataEnterprisePayment, {
    startDate: '',
    endDate: '',
    enterprise: '',
    status: null,
  });
};
const mountFilter = () => {
  Object.assign(dataEnterprisePayment, {
    startDate: props.filter.startDate,
    endDate: props.filter.endDate,
    enterprise: props.filter.enterprise,
    status: props.filter.status,
  });
};

const isOpen = computed({
  get: () => props.open,
  set: (state: IFilterEnterprisePayment | 'close') =>
    emit('update:open', state),
});

watch(
  () => props.open,
  async () => {
    if (props.open) {
      clear();
      mountFilter();
    }
  }
);
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogContent hide-close-button>
      <DialogHeader>
        <DialogTitle>
          <TitlePage
            title="Filtro de pagamentos das empresas"
            icon="LucideFunnel"
          />
        </DialogTitle>
      </DialogHeader>
      <form @submit.prevent="send">
        <div class="mb-3 space-y-3">
          <div class="space-y-1">
            <Label for="startDate" class="font-bold">Data Inicial</Label>
            <Input
              v-maska="'##/##/####'"
              v-model="dataEnterprisePayment.startDate"
              id="startDate"
              placeholder="Insira uma data inicial"
            />
          </div>
          <div class="space-y-1">
            <Label for="endDate" class="font-bold">Data Final</Label>
            <Input
              v-maska="'##/##/####'"
              v-model="dataEnterprisePayment.endDate"
              id="endDate"
              placeholder="Insira uma data final"
            />
          </div>
          <div class="space-y-1">
            <Label for="enterprise" class="font-bold">Nome da empresa</Label>
            <Input
              v-model="dataEnterprisePayment.enterprise"
              id="enterprise"
              placeholder="Insira o nome da empresa"
            />
          </div>
          <div class="space-y-1">
            <Label>Status</Label>
            <Select v-model="dataEnterprisePayment.status">
              <SelectTrigger class="w-full cursor-pointer">
                <SelectValue placeholder="Selecione um status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem
                  v-for="item in listStatus"
                  class="cursor-pointer"
                  :key="item.value"
                  :value="item.value"
                  >{{ item.name }}</SelectItem
                >
              </SelectContent>
            </Select>
          </div>
        </div>
        <div class="mt-3 flex justify-end">
          <Button
            type="button"
            @click="emit('update:open', 'close')"
            class="mr-2 cursor-pointer bg-red-300 hover:bg-red-400"
            :disabled="false"
          >
            Fechar
          </Button>
          <Button
            type="button"
            @click="clear"
            class="mr-2 cursor-pointer bg-gray-500 hover:bg-gray-600"
            :disabled="false"
          >
            Limpar
          </Button>
          <Button type="submit" class="cursor-pointer px-8" :disabled="false">
            <LucideLoader2 v-if="false" class="mr-2 h-4 w-4 animate-spin" />
            {{ false ? 'Carregando...' : 'Filtrar' }}
          </Button>
        </div>
      </form>
    </DialogContent>
  </Dialog>
</template>

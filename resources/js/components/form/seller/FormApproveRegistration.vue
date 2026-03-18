<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { useSellerStore } from '@/stores/seller-store';
import { storeToRefs } from 'pinia';
import { validateApproveRegistration } from './validation';
import { formatDateBrazil } from '@/composables/useFormat';

defineOptions({
  name: 'ConfirmAction',
});

const props = defineProps<{
  open: boolean;
  registration: ISellerRegistration | null;
}>();
const emit = defineEmits<{
  'update:open': [value: boolean];
}>();

const { loadingSeller } = storeToRefs(useSellerStore());

const form = reactive({
  name: '',
  email: '',
  phone: '',
  dateCreated: '',
  description: '',
  code: '',
});
const clear = () => {
  Object.assign(form, {
    name: '',
    email: '',
    phone: '',
    dateCreated: '',
    description: '',
    code: '',
  });
};
const approve = async () => {
  const status = validateApproveRegistration(form);
  if (status.status) {
    const response = await useSellerStore().approveSellerRegistration(
      props.registration?.id ?? 0,
      form.code
    );
    if (response?.status === 201) {
      await useSellerStore().getSellersRegistration();
      emit('update:open', false);
    }
  }
};
const mountData = () => {
  Object.assign(form, {
    code: '',
    name: props.registration?.name ?? '',
    email: props.registration?.email ?? '',
    phone: props.registration?.phone ?? '',
    description: props.registration?.description ?? '',
    dateCreated: formatDateBrazil(props.registration?.created_at ?? ''),
  });
};

const isOpen = computed({
  get: () => props.open,
  set: (value) => emit('update:open', value),
});

watch(isOpen, () => {
  if (isOpen.value) {
    clear();
    mountData();
  }
});
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle class="text-xl leading-none font-semibold tracking-tight">
          Aprovação de cadastro
        </DialogTitle>
        <DialogDescription class="text-muted-foreground">
          Realize a aprovação de um novo associado ao dalle manage
        </DialogDescription>
      </DialogHeader>

      <form>
        <div class="mt-2 space-y-2">
          <Label for="name" class="ml-1 font-bold">Nome</Label>
          <Input v-model="form.name" disabled />
        </div>
        <div class="mt-2 space-y-2">
          <Label for="code" class="ml-1 font-bold">E-mail</Label>
          <Input v-model="form.email" disabled />
        </div>
        <div class="mt-2 space-y-2">
          <Label for="code" class="ml-1 font-bold">Telefone</Label>
          <Input v-model="form.phone" disabled />
        </div>
        <div class="mt-2 space-y-2">
          <Label for="code" class="ml-1 font-bold">Data de inscrição</Label>
          <Input v-model="form.dateCreated" disabled />
        </div>
        <div class="mt-2 space-y-2">
          <Label for="code" class="ml-1 font-bold">Código</Label>
          <Input
            v-model="form.code"
            type="code"
            id="code"
            placeholder="Insira o código do(a) vendedor(a)"
            autocomplete="new-code"
          />
        </div>
      </form>

      <DialogFooter class="mt-6 flex justify-end gap-2">
        <Button
          variant="outline"
          @click="isOpen = false"
          :disabled="loadingSeller"
        >
          Cancelar
        </Button>

        <Button @click="approve" class="px-8" :disabled="loadingSeller">
          <span
            v-if="loadingSeller"
            class="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"
          ></span>
          {{ loadingSeller ? 'Aprovando...' : 'Aprovar' }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>

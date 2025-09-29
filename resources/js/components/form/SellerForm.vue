<script setup lang="ts">
import { computed, watch } from 'vue';
import TitlePage from '../general/TitlePage.vue';
import { useForm } from '@inertiajs/vue3';
import { phoneValidation } from '@/composables/PhoneValidation';

defineOptions({
  name: 'SellerForm',
});

const props = defineProps<{
  data: {
    open: boolean;
    seller: ISeller | null;
  };
}>();
const emit = defineEmits<{
  'update:open': [void];
}>();

const form = useForm({
  name: '',
  email: '',
  phone: '',
  code: '',
});

const create = () => {
  form.post(route('seller.create'), {
    onSuccess: () => {
      emit('update:open');
    },
  });
};
const update = () => {
  form.put(route('seller.update', props.data.seller?.id), {
    onSuccess: () => {
      emit('update:open');
    },
  });
};
const checkDataEdit = () => {
  if (props.data.seller) {
    Object.assign(form, {
      name: props.data.seller.name,
      email: props.data.seller.email,
      phone: props.data.seller.phone,
      code: props.data.seller.code,
    });
  }
};
const clear = () => {
  ((form.name = ''),
    (form.email = ''),
    (form.phone = ''),
    (form.code = ''),
    form.clearErrors());
};

const open = computed({
  get: () => props.data.open,
  set: () => emit('update:open'),
});

watch(
  () => form.code,
  (value: string) => {
    if (value !== null) {
      form.code = value.toUpperCase();
    }
  }
);
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
watch(open, () => {
  if (open.value) {
    clear();
    checkDataEdit();
  }
});
watch(
  () => form.errors,
  (errors) => {
    Object.keys(errors).forEach((field) => {
      setTimeout(() => {
        delete form.errors[field];
      }, 3000);
    });
  },
  { deep: true }
);
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>
          <TitlePage
            :title="
              props.data.seller
                ? 'Atualização de vendedor'
                : 'Criação de vendedor'
            "
          />
        </DialogTitle>
        <Separator class="my-1 bg-gray-500" />
      </DialogHeader>
      <form @submit.prevent="props.data.seller ? update() : create()">
        <div class="mb-2 space-y-2">
          <Label for="name" class="ml-1 font-bold">Nome</Label>
          <Input
            v-model="form.name"
            type="name"
            id="name"
            placeholder="Insira o nome do(a) vendedor(a)"
            autocomplete="new-name"
          />
        </div>
        <div class="mb-2 space-y-2">
          <Label for="email" class="ml-1 font-bold">Email</Label>
          <Input
            v-model="form.email"
            type="email"
            id="email"
            placeholder="Insira o email do(a) vendedor(a)"
            autocomplete="new-email"
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
          <Label for="code" class="ml-1 font-bold">Código</Label>
          <Input
            v-model="form.code"
            type="name"
            id="code"
            placeholder="Insira o código do(a) vendedor(a)"
            autocomplete="new-name"
          />
        </div>
        <div
          class="mt-2 ml-1 text-sm font-bold text-red-600"
          v-if="
            form.errors.name ||
            form.errors.email ||
            form.errors.phone ||
            form.errors.code ||
            form.errors.error
          "
        >
          {{
            form.errors.name ||
            form.errors.email ||
            form.errors.phone ||
            form.errors.code ||
            form.errors.error
          }}
        </div>
        <div class="mt-4 flex w-full justify-center space-y-2">
          <Button class="w-full cursor-pointer">
            <div v-if="form.processing">
              <Loader2 class="mr-2 h-4 w-4 animate-spin" />
            </div>
            <div v-else>{{ props.data.seller ? 'Salvar' : 'Criar' }}</div>
          </Button>
        </div>
      </form>
    </DialogContent>
  </Dialog>
</template>

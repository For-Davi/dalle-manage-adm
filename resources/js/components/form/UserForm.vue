<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, watch, ref } from 'vue';
import TitlePage from '../general/TitlePage.vue';
import Switch from '../switch/Switch.vue';

defineOptions({
  name: 'UserForm',
});

const page = usePage();

const props = defineProps<{
  data: {
    open: boolean;
    user: IUser | null;
  };
}>();
const emit = defineEmits<{
  'update:open': [void];
}>();

const form = useForm({
  changePassword: 0,
  name: '',
  email: '',
  currentPassword: '',
  password: '',
});
const confirmPassword = ref('');

const create = () => {
  if (form.password === confirmPassword.value) {
    form.post(route('user.create'), {
      onSuccess: () => {
        emit('update:open');
      },
    });
  } else {
    form.errors.password = 'As senhas não coincidem';
  }
};
const update = () => {
  if (form.password === confirmPassword.value) {
    form.put(route('user.update', props.data.user?.id), {
      onSuccess: () => {
        emit('update:open');
      },
    });
  } else {
    form.errors.password = 'As senhas não coincidem';
  }
};
const checkDataEdit = () => {
  if (props.data.user) {
    Object.assign(form, {
      name: props.data.user.name,
      email: props.data.user.email,
    });
  }
};
const clear = () => {
  form.changePassword = 0,
    form.name = '',
    form.email = '',
    form.currentPassword = '',
    form.password = '',
    confirmPassword.value = '',
    form.clearErrors();
};

const open = computed({
  get: () => props.data.open,
  set: () => emit('update:open'),
});
const userId = computed(() => page.props.auth.user?.id);

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
              props.data.user ? 'Edição de usuário' : 'Criação de usuário'
            "
          />
        </DialogTitle>
        <Separator class="my-1 bg-gray-500" />
      </DialogHeader>
      <form @submit.prevent="props.data.user ? update() : create()">
        <div class="mb-2 space-y-2">
          <Label for="name" class="ml-1 font-bold">Nome</Label>
          <Input
            v-model="form.name"
            type="name"
            id="name"
            placeholder="Insira o nome do usuário"
            autocomplete="new-name"
          />
        </div>
        <div class="mb-2 space-y-2">
          <Label for="email" class="ml-1 font-bold">Email</Label>
          <Input
            v-model="form.email"
            type="email"
            id="email"
            placeholder="Insira o email do usuário"
          />
        </div>
        <div v-if="!props.data.user || props.data.user.id === userId">
          <div class="mb-2 space-y-2" v-if="props.data.user">
            <Label for="switchChangePassword" class="ml-1 font-bold"
              >Alterar senha</Label
            >
            <Switch
              v-model="form.changePassword"
              id="switchChangePassword"
              class="ml-1 cursor-pointer"
            />
          </div>
          <div class="mb-2 space-y-2" v-if="form.changePassword">
            <Label for="currentPassword" class="ml-1 font-bold"
              >Senha atual</Label
            >
            <Input
              v-model="form.currentPassword"
              type="password"
              id="currentPassword"
              placeholder="Insira a senha atual"
            />
          </div>
          <div
            class="mb-2 space-y-2"
            v-if="form.changePassword || !props.data.user"
          >
            <Label for="password" class="ml-1 font-bold">{{
              props.data.user ? 'Nova senha' : 'Senha'
            }}</Label>
            <Input
              v-model="form.password"
              type="password"
              id="password"
              :placeholder="
                props.data.user ? 'Insira a nova senha' : 'Insira a senha'
              "
            />
          </div>
          <div
            class="mb-2 space-y-2"
            v-if="form.changePassword || !props.data.user"
          >
            <Label for="confirmPassword" class="ml-1 font-bold">{{
              props.data.user ? 'Confirme a nova senha' : 'Confirme a senha'
            }}</Label>
            <Input
              v-model="confirmPassword"
              type="password"
              id="confirmPassword"
              :placeholder="
                props.data.user ? 'Confirme a nova senha' : 'Confirme a senha'
              "
            />
          </div>
        </div>
        <div
          class="mt-2 ml-1 text-sm font-bold text-red-600"
          v-if="
            form.errors.name ||
            form.errors.email ||
            form.errors.password ||
            form.errors.currentPassword ||
            form.errors.changePassword ||
            form.errors.error
          "
        >
          {{
            form.errors.name ||
            form.errors.email ||
            form.errors.password ||
            form.errors.currentPassword ||
            form.errors.changePassword ||
            form.errors.error
          }}
        </div>
        <div v-if="props.data.user" class="mt-4 w-full">
          <Button class="w-full cursor-pointer"> Salvar </Button>
        </div>
        <div v-else class="mt-4 w-full">
          <Button class="w-full cursor-pointer"> Criar </Button>
        </div>
      </form>
    </DialogContent>
  </Dialog>
</template>

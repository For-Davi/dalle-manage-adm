<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, watch, ref } from 'vue';
import TitlePage from '../general/TitlePage.vue';
import { canEditSelfData, canEditRole } from '@/composables/Roles';

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
  name: '',
  email: '',
  role: '',
  password: '',
});
const confirmPassword = ref('');

const create = () => {
  if (form.password === confirmPassword.value) {
    form.post(route('user.create'));
  } else {
    form.errors.password = 'As senhas não coincidem';
  }
};
const update = () => {
  if (form.password === confirmPassword.value) {
    form.put(route('user.update', props.data.user?.id));
  } else {
    form.errors.password = 'As senhas não coincidem';
  }
};
const checkDataEdit = () => {
  if (props.data.user) {
    Object.assign(form, {
      name: props.data.user.name,
      email: props.data.user.email,
      role: props.data.user.role,
    });
  }
};
const clear = () => {
  ((form.name = ''),
    (form.email = ''),
    (form.role = ''),
    (form.password = ''),
    (confirmPassword.value = ''),
    form.clearErrors());
};

const open = computed({
  get: () => props.data.open,
  set: () => emit('update:open'),
});
const userRole = computed(() => page.props.auth.user?.role);

watch(open, () => {
  if (open.value) {
    clear();
    checkDataEdit();
  }
});
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
        <div
          class="mb-2 space-y-2"
          v-if="canEditSelfData(userRole, props.data.user)"
        >
          <Label for="name" class="ml-1 font-bold">Nome</Label>
          <Input
            v-model="form.name"
            type="name"
            id="name"
            placeholder="Insira o nome do usuário"
            autocomplete="new-name"
          />
        </div>
        <div
          class="mb-2 space-y-2"
          v-if="canEditSelfData(userRole, props.data.user)"
        >
          <Label for="email" class="ml-1 font-bold">Email</Label>
          <Input
            v-model="form.email"
            type="email"
            id="email"
            placeholder="Insira o email do usuário"
          />
        </div>
        <div
          class="mb-2 w-full space-y-2"
          v-if="canEditRole(userRole, props.data.user, props.data.user?.role)"
        >
          <Label for="role" class="ml-1 font-bold">Cargo</Label>
          <Select id="role" v-model="form.role">
            <SelectTrigger class="w-full cursor-pointer">
              <SelectValue placeholder="Selecione um cargo" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem class="cursor-pointer" value="common_user">
                  Usuário Comum
                </SelectItem>
                <SelectItem class="cursor-pointer" value="admin">
                  Admin
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
        </div>
        <div class="mb-2 space-y-2">
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
        <div class="mb-2 space-y-2">
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
        <div
          class="mt-2 ml-1 text-sm font-bold text-red-600"
          v-if="
            form.errors.name ||
            form.errors.email ||
            form.errors.role ||
            form.errors.password ||
            form.errors.error
          "
        >
          {{
            form.errors.name ||
            form.errors.email ||
            form.errors.role ||
            form.errors.password ||
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

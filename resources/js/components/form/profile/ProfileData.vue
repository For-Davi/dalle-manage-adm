<script setup lang="ts">
import { reactive, watch } from 'vue';
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth-store';
import { validateUpdateData } from './validation';

defineOptions({
  name: 'ProfileData',
});

const { user, loadingAuth } = storeToRefs(useAuthStore());

const props = defineProps<{
  user: IUserAdm | null;
  type: 'data' | 'password';
}>();
const emit = defineEmits<{
  updateType: ['password'];
  'update:open': [void];
}>();

const form = reactive({
  name: '',
  email: '',
});

const submit = async () => {
  const status = validateUpdateData(form);
  if (status.status) {
    const response = await useAuthStore().updateData(form);
    if (response?.status === 200) {
      emit('update:open');
    }
  }
};
const mountData = async () => {
  Object.assign(form, {
    name: user.value?.name || '',
    email: props.user?.email || '',
  });
};

watch(
  () => props.type,
  (type) => {
    if (type === 'data') {
      mountData();
    }
  },
  { immediate: true }
);
</script>

<template>
  <section>
    <form @submit.prevent="submit">
      <div class="mb-3 space-y-1">
        <Label for="name" class="font-bold">Nome</Label>
        <Input v-model="form.name" id="name" placeholder="Insira um nome" />
      </div>
      <div class="space-y-1">
        <Label for="email" class="font-bold">Email</Label>
        <Input v-model="form.email" id="email" placeholder="Insira um email" />
      </div>
      <div class="mt-3 flex justify-end">
        <Button
          @click="emit('updateType', 'password')"
          class="mr-2 cursor-pointer bg-gray-500 hover:bg-gray-600"
        >
          Alterar senha
        </Button>
        <Button type="submit" class="px-8" :disabled="loadingAuth">
          <LucideLoader2 v-if="loadingAuth" class="mr-2 h-4 w-4 animate-spin" />
          {{ loadingAuth ? 'Salvando...' : 'Atualizar dados' }}
        </Button>
      </div>
    </form>
  </section>
</template>

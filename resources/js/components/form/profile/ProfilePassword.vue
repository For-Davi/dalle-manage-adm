<script setup lang="ts">
import { reactive, ref } from 'vue';
import { validateUpdatePassword } from './validation';
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth-store';

defineOptions({
  name: 'ProfilePassword',
});

const emit = defineEmits<{
  updateType: ['data'];
  'update:open': [void];
}>();

const { loadingAuth } = storeToRefs(useAuthStore());

const form = reactive({
  currentPassword: '',
  password: '',
});
const confirmPassword = ref('');

const submit = async () => {
  const status = validateUpdatePassword({
    ...form,
    confirmPassword: confirmPassword.value,
  });
  if (status.status) {
    const response = await useAuthStore().updatePassword(form);
    if (response?.status === 200) {
      emit('update:open');
    }
  }
};
</script>

<template>
  <section>
    <form @submit.prevent="submit">
      <div class="mb-3 space-y-1">
        <Label for="currentPassword" class="font-bold">Senha atual</Label>
        <Input
          v-model="form.currentPassword"
          id="currentPassword"
          type="password"
          placeholder="Insira a senha atual"
        />
      </div>
      <div class="mb-3 space-y-1">
        <Label for="password" class="font-bold">Nova senha</Label>
        <Input
          v-model="form.password"
          id="password"
          type="password"
          placeholder="Insira a nova senha"
        />
      </div>
      <div class="space-y-1">
        <Label for="confirmPassword" class="font-bold"
          >Confirme a nova senha</Label
        >
        <Input
          v-model="confirmPassword"
          id="confirmPassword"
          type="password"
          placeholder="Confirme a nova senha"
        />
      </div>
      <div class="mt-3 flex justify-end">
        <Button
          @click="emit('updateType', 'data')"
          class="mr-2 cursor-pointer bg-gray-500 hover:bg-gray-600"
        >
          Alterar dados
        </Button>
        <Button type="submit" class="px-8" :disabled="loadingAuth">
          <LucideLoader2 v-if="loadingAuth" class="mr-2 h-4 w-4 animate-spin" />
          {{ loadingAuth ? 'Salvando...' : 'Atualizar senha' }}
        </Button>
      </div>
    </form>
  </section>
</template>

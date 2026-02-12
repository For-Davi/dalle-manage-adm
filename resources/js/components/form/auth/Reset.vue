<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth-store';
import { onMounted, reactive } from 'vue';

defineOptions({
  name: 'Reset',
});

const emit = defineEmits<{
  'update:changeRender': [IRenderAuth];
}>();

const { loadingAuth } = storeToRefs(useAuthStore());

const form = reactive({
  email: '',
});

const submit = async () => {
  await useAuthStore().reset(form.email);
  form.email = ';';
  emit('update:changeRender', 'auth');
};
const clear = () => {
  form.email = '';
};

onMounted(() => {
  clear();
});
</script>

<template>
  <Card class="w-100">
    <CardHeader>
      <CardTitle>Dalle Manage Adm</CardTitle>
      <CardDescription> Esqueceu sua senha? </CardDescription>
    </CardHeader>
    <CardContent class="space-y-2">
      <form @submit.prevent="submit">
        <div class="mb-3 space-y-1">
          <Label for="email">Email</Label>
          <Input
            v-model="form.email"
            id="email"
            placeholder="Insira seu email"
            autocomplete="new-email"
          />
        </div>
        <div class="mt-2">
          <span
            @click="emit('update:changeRender', 'auth')"
            class="ml-1 cursor-pointer text-sm underline"
            >Entrar na conta</span
          >
        </div>
      </form>
    </CardContent>
    <CardFooter>
      <Button type="submit" class="px-8" :disabled="loadingAuth">
        <LucideLoader2 v-if="loadingAuth" class="mr-2 h-4 w-4 animate-spin" />
        {{ loadingAuth ? 'Enviando...' : 'Enviar redefinição' }}
      </Button>
    </CardFooter>
  </Card>
</template>

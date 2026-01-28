<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth-store';
import { reactive } from 'vue';

defineOptions({
  name: 'AuthForm',
});

const emit = defineEmits<{
  'update:changeRender': [IRenderAuth];
}>();

const { loadingAuth } = storeToRefs(useAuthStore());

const form = reactive({
  email: '',
  password: '',
});

const submit = async () => {
  await useAuthStore().login(form);
};
</script>

<template>
  <Card class="w-100">
    <CardHeader>
      <CardTitle>Dalle Manage Adm</CardTitle>
      <CardDescription> Faça seu login </CardDescription>
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
        <div class="space-y-1">
          <Label for="password">Password</Label>
          <Input
            v-model="form.password"
            id="password"
            type="password"
            placeholder="Insira sua senha"
            autocomplete="new-password"
          />
        </div>
        <div class="mt-2">
          <span
            @click="emit('update:changeRender', 'reset')"
            class="ml-1 cursor-pointer text-sm underline"
            >Esqueceu sua senha?</span
          >
        </div>
      </form>
    </CardContent>
    <CardFooter>
      <Button
        type="submit"
        class="w-full cursor-pointer"
        :disabled="loadingAuth"
        @click="submit"
      >
        <div v-if="loadingAuth">
          <Loader2 class="mr-2 h-4 w-4 animate-spin" />
        </div>
        <div v-else>Entrar</div>
      </Button>
    </CardFooter>
  </Card>
</template>

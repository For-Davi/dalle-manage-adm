<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';

defineOptions({
  name: 'FormAuth',
});

const emit = defineEmits<{
  'update:changeRender': [IRenderAuth];
}>();

const form = useForm({
  email: '',
  password: '',
});

const submit = async () => {
  form.post(route('user.login'), {
    onFinish: () => form.reset('password'),
  });
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
        <div v-if="form.errors.email" class="mt-2">
          <p class="ml-6 text-sm font-medium text-red-600">
            {{ form.errors.email }}
          </p>
        </div>
      </form>
    </CardContent>
    <CardFooter>
      <Button
        type="submit"
        class="w-full cursor-pointer"
        :disabled="form.processing"
        @click="submit"
      >
        <div v-if="form.processing">
          <Loader2 class="mr-2 h-4 w-4 animate-spin" />
        </div>
        <div v-else>Entrar</div>
      </Button>
    </CardFooter>
  </Card>
</template>

<script setup lang="ts">
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
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import { toast } from 'vue-sonner';

defineOptions({
  name: 'Reset',
});

const emit = defineEmits<{
  'update:changeRender': [IRenderAuth];
}>();

const form = useForm({
  email: '',
});

const submit = async () => {
  form.post(route('verify.reset'), {
    onFinish: () => {
      form.reset('email');
      emit('update:changeRender','auth')
    },
    onSuccess: () => {
      toast.success(
        'Caso o e-mail esteja em nossos registro, você receberá um email para a redefinição de senha'
      );
    },
  });
};
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
          />
        </div>
        <div class="mt-2">
          <span
            @click="emit('update:changeRender', 'auth')"
            class="ml-1 cursor-pointer text-sm underline"
            >Entrar na conta</span
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
        <div v-else>Enviar</div>
      </Button>
    </CardFooter>
  </Card>
</template>

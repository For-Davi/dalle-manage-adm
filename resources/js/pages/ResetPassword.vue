<script setup lang="ts">
import {
  Card,
  CardContent,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Loader2 } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner'
import { ref } from 'vue';

defineOptions({
  name: 'ResetPassword',
});

const props = defineProps<{
  token: string;
}>();

const form = useForm({
  password: '',
  token: props.token,
});
const confirmPassword = ref('');

const submit = () => {
  if (confirmPassword.value !== form.password) {
    form.setError('password', 'As senhas não coincidem');
  } else {
    form.clearErrors('password');
    toast.success('Senha redefinida')
    form.put(route('user.reset'));
    form.reset('password'); 
    confirmPassword.value = '';
  }
};
</script>

<template>
  <main class="flex h-screen w-screen items-center justify-center">
    <Card class="w-100">
      <CardHeader>
        <CardTitle>Redefina sua senha</CardTitle>
      </CardHeader>
      <CardContent class="space-y-2">
        <form @submit.prevent="submit">
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
          <div v-if="form.errors.password">
            <p class="mt-2 ml-1 text-sm font-bold font-medium text-red-600">
              {{ form.errors.password }}
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
          <div v-else>Redefinir senha</div>
        </Button>
      </CardFooter>
    </Card>
  </main>
</template>

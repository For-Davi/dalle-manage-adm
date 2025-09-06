<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button';
import { ref } from 'vue'

defineOptions({
    name:'ProfilePassword'
})


const emit = defineEmits<{
  updateType: ['data'],
  'update:open': [void]
}>()

const form = useForm({
    currentPassword: '',
    password: '',
})
const confirmPassword = ref('')

const submit = () => {
    if(confirmPassword.value !== form.password) {
      form.setError('password', 'As senhas não coincidem')
    } else {
      form.clearErrors('password')
      form.put(route('user.update.password'), {
      onSuccess: () => emit('update:open')
    })
    }
}
</script>

<template>
   <section>
     <form @submit.prevent="submit">
        <div class="space-y-1 mb-3">
              <Label for="currentPassword" class="font-bold">Senha atual</Label>
              <Input v-model="form.currentPassword" id="currentPassword" type="password" placeholder="Insira a senha atual" />
            </div>
               <div class="space-y-1 mb-3">
              <Label for="password" class="font-bold">Nova senha</Label>
              <Input v-model="form.password" id="password" type="password" placeholder="Insira a nova senha"/>
            </div>
            <div class="space-y-1">
              <Label for="confirmPassword" class="font-bold">Confirme a nova senha</Label>
              <Input v-model="confirmPassword" id="confirmPassword" type="password" placeholder="Confirme a nova senha"/>
            </div>
            <div v-if="form.errors.password" >
            <p class="ml-1 mt-2 text-sm text-red-600 font-bold font-medium">{{ form.errors.password }}</p>
          </div>
            <div class="flex justify-end mt-3">
              <Button @click="emit('updateType', 'data')" class="bg-gray-500 cursor-pointer mr-2 hover:bg-gray-600">
               Alterar dados
              </Button>
              <Button class="cursor-pointer">
                <div v-if="form.processing">
                <Loader2 class="w-4 h-4 mr-2 animate-spin" />
                </div>
                <div v-else>Atualizar senha</div>
              </Button>
            </div>
     </form>
   </section>
</template>
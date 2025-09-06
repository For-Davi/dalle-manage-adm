<script setup lang="ts">
import { watch } from 'vue'
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button';

defineOptions({
    name:'ProfileData'
})

const props = defineProps<{
    user: IUser | null
    type: 'data' | 'password'
}>()
const emit = defineEmits<{
  updateType: ['password'],
  'update:open': [void]
}>()

const form = useForm({
    name: '',
    email: ''
})

const submit = () => {
  form.put(route('user.update.data'), {
      onSuccess: () => emit('update:open')
    })
}
const mountData = async () => {
  form.name = props.user?.name ?? '',
  form.email = props.user?.email ?? ''
};

watch(
  () => props.type,
  (type) => {
    if (type === 'data') {
      mountData();
    }
  },
  { immediate: true },
);
</script>

<template>
   <section>
     <form @submit.prevent="submit">
        <div class="space-y-1 mb-3">
              <Label for="name" class="font-bold">Nome</Label>
              <Input v-model="form.name" id="name" placeholder="Insira um nome" />
            </div>
               <div class="space-y-1">
              <Label for="email" class="font-bold">Email</Label>
              <Input v-model="form.email" id="email" placeholder="Insira um email"/>
            </div>
            <div v-if="form.errors.email" >
            <p class="ml-1 mt-2 text-sm text-red-600 font-bold font-medium">{{ form.errors.email }}</p>
          </div>
            <div class="flex justify-end mt-3">
              <Button @click="emit('updateType', 'password')" class="bg-gray-500 cursor-pointer mr-2 hover:bg-gray-600">
               Alterar senha
              </Button>
              <Button class="cursor-pointer">
                <div v-if="form.processing">
                <Loader2 class="w-4 h-4 mr-2 animate-spin" />
                </div>
                <div v-else>Atualizar dados</div>
              </Button>
            </div>
     </form>
   </section>
</template>
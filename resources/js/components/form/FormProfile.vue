<script setup lang="ts">
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle
} from '@/components/ui/dialog'
import { computed, ref } from 'vue'
import ProfileData from '../profile/ProfileData.vue';
import ProfilePassword from '../profile/ProfilePassword.vue';
import { CircleUserRound, Lock  } from 'lucide-vue-next';

defineOptions({
    name:'FormProfile'
})

const props = defineProps<{
    data: {
        open: boolean;
        user: IUser | null
    }
}>()
const emit = defineEmits<{
  'update:open': [void]
}>()

const type = ref<'data' | 'password'>('data')

const changeType = (mode: 'data' | 'password') => {
  type.value = mode
}

const open = computed({
  get: () => props.data.open,
  set: () => emit('update:open'),
});
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent>
             <DialogHeader>
              <DialogTitle>
                <div class="flex">
                <CircleUserRound v-if="type === 'data'" class="mr-2 w-8 h-7" />
                <Lock v-else class="mr-2 w-8 h-7" />
                <p class="font-bold text-xl">{{ type === 'data' ? 'Atualização de dados' : 'Atualização de senha'}}</p>
              </div>
              </DialogTitle>
        </DialogHeader>
        
        <div>
           <ProfileData
           v-if="type === 'data'"
           :user="props.data.user"
           @updateType="changeType"
           @update:open="emit('update:open')"
           :type="type"
           />
       
           <ProfilePassword
           v-else
           @updateType="changeType"
           @update:open="emit('update:open')"
           />
        </div>
        </DialogContent>
    </Dialog>
</template>
<script setup lang="ts">
import { computed, ref } from 'vue';
import ProfileData from '../profile/ProfileData.vue';
import ProfilePassword from '../profile/ProfilePassword.vue';

defineOptions({
  name: 'ProfileForm',
});

const props = defineProps<{
  data: {
    open: boolean;
    user: IUserAdm | null;
  };
}>();
const emit = defineEmits<{
  'update:open': [void];
}>();

const type = ref<'data' | 'password'>('data');

const changeType = (mode: 'data' | 'password') => {
  type.value = mode;
};

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
            <LucideCircleUserRound
              v-if="type === 'data'"
              class="mr-2 h-7 w-8"
            />
            <LucideLock v-else class="mr-2 h-7 w-8" />
            <p class="text-xl font-bold">
              {{
                type === 'data'
                  ? 'Atualização de dados'
                  : 'Atualização de senha'
              }}
            </p>
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

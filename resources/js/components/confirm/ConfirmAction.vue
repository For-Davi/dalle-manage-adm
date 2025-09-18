<script setup lang="ts">
import { computed } from 'vue';

defineOptions({
  name: 'ConfirmAction',
});

const emit = defineEmits<{
  'update:open': [void];
  okConfirmAction: [void];
}>();

const props = defineProps<{
  open: boolean;
  title: string;
  message: string;
}>();

const open = computed({
  get: () => props.open,
  set: () => emit('update:open'),
});
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>
          <div class="flex">
            <p class="text-xl font-bold">
              {{ props.title }}
            </p>
          </div>
        </DialogTitle>
        <Separator class="my-1 bg-gray-500" />
      </DialogHeader>

      <div class="text-lg font-bold text-red-500">
        {{ props.message }}
      </div>

      <div class="flex justify-end">
        <Button
          class="cursor-pointer bg-red-500 hover:bg-red-700"
          @click="emit('okConfirmAction')"
        >
          Confirmar
        </Button>
      </div>
    </DialogContent>
  </Dialog>
</template>

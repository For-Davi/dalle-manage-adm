<script setup lang="ts">
import { computed } from 'vue';

defineOptions({
  name: 'ConfirmAction',
});

const props = withDefaults(
  defineProps<{
    open: boolean;
    title: string;
    message: string;
    confirmText?: string;
    cancelText?: string;
    variant?: 'default' | 'destructive';
    loading?: boolean;
  }>(),
  {
    confirmText: 'Confirmar',
    cancelText: 'Cancelar',
    variant: 'destructive',
    loading: false,
  }
);

const emit = defineEmits<{
  'update:open': [value: boolean];
  confirm: [void];
}>();

const isOpen = computed({
  get: () => props.open,
  set: (value) => emit('update:open', value),
});
</script>

<template>
  <Dialog v-model:open="isOpen">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle class="text-xl leading-none font-semibold tracking-tight">
          {{ title }}
        </DialogTitle>
        <DialogDescription class="text-muted-foreground pt-4">
          {{ message }}
        </DialogDescription>
      </DialogHeader>

      <DialogFooter class="mt-6 flex justify-end gap-2">
        <Button variant="outline" @click="isOpen = false" :disabled="loading">
          {{ cancelText }}
        </Button>

        <Button :variant="variant" :disabled="loading" @click="emit('confirm')">
          <span
            v-if="loading"
            class="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-current border-t-transparent"
          ></span>
          {{ confirmText }}
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>

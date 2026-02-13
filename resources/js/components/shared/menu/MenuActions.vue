<script setup lang="ts">
import { LucideLoader2 } from 'lucide-vue-next';

defineProps<{
  actions: IMenuAction[];
}>();
</script>

<template>
  <div class="mt-8 flex items-center justify-end gap-4">
    <Button
      v-for="(action, i) in actions"
      :key="i"
      :type="action.type || 'button'"
      :variant="action.variant || 'default'"
      :class="action.class"
      :disabled="action.disabled"
      @click="action.onClick"
    >
      {{ action.label }}

      <LucideLoader2 v-if="action.loading" class="mr-2 h-4 w-4 animate-spin" />
      <component
        v-else-if="action.icon"
        :is="action.icon"
        class="mr-2 h-4 w-4"
      />
    </Button>
  </div>
</template>

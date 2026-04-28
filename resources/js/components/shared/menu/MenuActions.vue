<script setup lang="ts">
import { LucideLoader2 } from 'lucide-vue-next';

defineProps<{
  actions: IMenuAction[];
}>();
</script>

<template>
  <div class="mt-8 flex items-center justify-end gap-4">
    <div
      v-for="(action, i) in actions"
      :key="i"
      class="relative inline-flex"
    >
      <Button
        :type="action.type || 'button'"
        :variant="action.variant || 'default'"
        :class="action.class"
        :disabled="action.disabled"
        @click="action.onClick"
      >
        {{ action.label }}
        <LucideLoader2 v-if="action.loading" class="mr-2 h-4 w-4 animate-spin" />
        <component v-else-if="action.icon" :is="action.icon" class="mr-2 h-4 w-4" />
      </Button>

      <Badge
        v-if="action.badge"
        class="absolute -top-2 -right-2 size-5 p-0 flex items-center justify-center rounded-full bg-gray-500"
      >
      </Badge>
    </div>
  </div>
</template>

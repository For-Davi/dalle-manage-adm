<script setup lang="ts">
import * as LucideIcons from 'lucide-vue-next';
import { computed } from 'vue';

defineOptions({
  name: 'Empty',
});

const props = defineProps<{
  message?: string;
  icon?: string;
}>();

const IconComponent = computed(() => {
  if (props.icon && LucideIcons[props.icon as keyof typeof LucideIcons]) {
    return LucideIcons[props.icon as keyof typeof LucideIcons];
  }
});
</script>

<template>
  <main class="flex flex-col items-center justify-center gap-2">
    <component v-if="IconComponent" :is="IconComponent" class="h-10 w-10" />
    <p class="rounded-borders text-lg">
      {{ props.message }}
    </p>
  </main>
</template>

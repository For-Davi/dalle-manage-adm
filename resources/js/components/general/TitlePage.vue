<script setup lang="ts">
import * as LucideIcons from 'lucide-vue-next';
import { computed } from 'vue';

defineOptions({
  name: 'TitlePage',
});

const props = defineProps<{
  title: string;
  icon?: string | null;
}>();

const iconComponent = computed(() => {
  if (!props.icon) return null;

  const pascalName = props.icon
    .replace(/(^\w|-\w)/g, (c) => c.replace('-', '').toUpperCase());

  return (LucideIcons as Record<string, unknown>)[pascalName] ?? null;
});
</script>

<template>
  <section class="flex items-center gap-2">
    <component
      :is="iconComponent"
      v-if="iconComponent"
      class="size-5"
    />
    <h1 class="text-xl font-bold">{{ props.title }}</h1>
  </section>
</template>

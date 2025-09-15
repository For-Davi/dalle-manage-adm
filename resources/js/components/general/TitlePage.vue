<script setup lang="ts">
import * as icons from 'lucide-vue-next';
import { computed } from 'vue';

defineOptions({
  name: 'TitlePage',
});

const props = defineProps<{
  title: string;
  icon: string;
}>();

const icon = computed(() => {
  return (icons as Record<string, any>)[props.icon];
});
</script>

<template>
  <section class="flex items-center gap-2">
    <component v-if="icon" :is="icon" class="h-6 w-6" />
    <h1 class="text-xl font-bold">{{ props.title }}</h1>
  </section>
</template>

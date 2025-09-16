<script setup lang="ts">

defineOptions({
  name: 'TitlePage',
});

const props = defineProps<{
  title: string;
  icon?: string|null;
}>();
</script>

<template>
  <section class="flex items-center gap-2">
    <h1 class="text-xl font-bold">{{ props.title }}</h1>
  </section>
</template>

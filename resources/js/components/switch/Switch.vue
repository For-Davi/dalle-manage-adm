<script setup lang="ts">
defineOptions({
  name: 'Switch',
});

import { computed } from 'vue';

const props = defineProps<{
  modelValue: boolean;
}>();

const emit = defineEmits<{
  'update:modelValue': [boolean];
}>();

const checked = computed({
  get: () => props.modelValue,
  set: (value: boolean) => emit('update:modelValue', value),
});
</script>

<template>
  <button
    type="button"
    role="switch"
    :aria-checked="checked"
    @click="checked = !checked"
    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
    :class="checked ? 'bg-slate-900' : 'bg-gray-300'"
  >
    <span
      class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
      :class="checked ? 'translate-x-6' : 'translate-x-1'"
    />
  </button>
</template>

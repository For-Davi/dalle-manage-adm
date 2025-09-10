<script setup lang="ts">
import FormAuth from '@/components/form/FormAuth.vue';
import Reset from '@/components/form/Reset.vue';
import { Toaster } from 'vue-sonner';
import { ref } from 'vue';

const type = ref<IRenderAuth>('auth');

const changeRender = (value: IRenderAuth) => {
  type.value = value;
};
</script>

<template>
  <main class="flex h-screen w-screen items-center justify-center">
    <FormAuth v-if="type === 'auth'" @update:change-render="changeRender" />
    <Reset v-else @update:change-render="changeRender" />
  </main>
  <Toaster position="bottom-right" />
</template>

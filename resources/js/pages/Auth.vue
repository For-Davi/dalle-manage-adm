<script setup lang="ts">
import Login from '@/components/form/auth/Login.vue';
import Reset from '@/components/form/auth/Reset.vue';
import { ref } from 'vue';

const type = ref<IRenderAuth>('auth');

const changeRender = (value: IRenderAuth) => {
  type.value = value;
};
</script>

<template>
  <main class="flex h-screen w-screen items-center justify-center">
    <Login v-if="type === 'auth'" @update:change-render="changeRender" />
    <Reset v-else @update:change-render="changeRender" />
  </main>
  <Toaster position="bottom-right" />
</template>

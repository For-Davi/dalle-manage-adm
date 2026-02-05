import router from '@/router';

export const goUrlName = async (name: string) => {
  await router.push({ name: name });
};

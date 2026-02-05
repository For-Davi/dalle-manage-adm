import router from '@/router';

export const goUrlName = async (name: string, params = {}) => {
  await router.push({ name: name, params });
};

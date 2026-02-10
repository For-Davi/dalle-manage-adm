import router from '@/router';

export const goUrlName = (name: string, params = {}) => {
  router.push({ name: name, params });
};

import { defineStore } from 'pinia';
import { useStorage } from '@vueuse/core';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: useStorage('dalle_manage_adm_user', {} as IUserAdm | null),
    token: useStorage('dalle_manage_adm_token', null as string | null),
    loadingAuth: false as boolean,
  }),

  actions: {
    setUser(user: IUserAdm | null) {
      this.user = user;
    },
  },
});

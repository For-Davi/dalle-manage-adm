import { defineStore } from 'pinia';
import { useStorage } from '@vueuse/core';
import {
  loginService,
  logoutService,
  resetPasswordService,
  resetService,
} from '@/services/auth-service';
import { createError, createSuccess } from '@/composables/useCreateNotify';
import router from '@/router';

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
    setToken(token: string | null) {
      this.token = token;
    },
    setLoading(loading: boolean) {
      this.loadingAuth = loading;
    },
    async login(data: IDataLogin) {
      try {
        this.setLoading(true);
        const response = await loginService(data);
        if (response.status === 200) {
          this.setUser(response.data.user);
          this.setToken(response.data.token);

          await router.push({ name: 'dashboard' });
        }
        return response;
      } catch (error) {
        createError(error);
      } finally {
        this.setLoading(false);
      }
    },
    async logout() {
      try {
        this.setLoading(true);
        const response = await logoutService();
        if (response.status === 200) {
          useAuthStore().setToken(null);
          useAuthStore().setUser(null);
          await router.push({ name: 'login' });
        }
        return response;
      } catch (error) {
        createError(error);
      } finally {
        this.setLoading(false);
      }
    },
    async reset(email: string) {
      try {
        this.setLoading(true);
        const response = await resetService(email);
        if (response.status === 200) {
          createSuccess(response.data.message);
        }

        return response;
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async setNewPassword(data: IDataResetPassword) {
      try {
        this.setLoading(true);
        const response = await resetPasswordService(data);
        if (response.status === 200) {
          createSuccess(response.data.message);
          await router.push({ name: 'login' });
        }

        return response;
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
  },
});

import { userRoutes } from './../router/modules/user.routes';
import { defineStore } from 'pinia';
import { createError, createSuccess } from '@/composables/useCreateNotify';
import {
  createUserService,
  deleteUserService,
  getUsersService,
  showUserService,
  updateProfileDataService,
  updateProfilePasswordService,
  updateUserService,
} from '@/services/user-adm-service';
import { useAuthStore } from './auth-store';

export const useUserAdmStore = defineStore('userAdm', {
  state: () => ({
    loadingUserAdm: false as boolean,
    listUsersAdm: [] as IUserAdm[],
  }),
  actions: {
    setLoading(loading: boolean) {
      this.loadingUserAdm = loading;
    },
    setListUsersAdm(data: IUserAdm[] = []) {
      this.listUsersAdm = data;
    },
    async getUsersAdm() {
      try {
        this.setLoading(true);
        const response = await getUsersService();
        if (response.status === 200) {
          this.setListUsersAdm(response.data.users);
        }
        return response;
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async showUserAdm(userID: number) {
      try {
        this.setLoading(true);
        return await showUserService(userID);
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async createUser(data: IDataUserAdm) {
      try {
        this.setLoading(true);
        const response = await createUserService(data);
        if (response.status === 201) {
          this.setListUsersAdm(response.data.users);
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
    async updateUser(userID: number, data: IDataUserAdm) {
      try {
        this.setLoading(true);
        const response = await updateUserService(userID, data);
        if (response.status === 200) {
          this.setListUsersAdm(response.data.users);
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
    async updateProfileData(data: IDataProfile) {
      try {
        this.setLoading(true);
        const response = await updateProfileDataService(data);
        if (response.status === 200) {
          useAuthStore().setUser(response.data.user);
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
    async updateProfilePassword(data: IDataProfilePassword) {
      try {
        this.setLoading(true);
        const response = await updateProfilePasswordService(data);
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
    async deleteUser(userID: number) {
      try {
        this.setLoading(true);
        const response = await deleteUserService(userID);
        if (response.status === 200) {
          this.setListUsersAdm(response.data.users);
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
  },
});

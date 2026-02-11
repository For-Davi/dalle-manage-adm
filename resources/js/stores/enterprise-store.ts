import { defineStore } from 'pinia';
import { createError, createSuccess } from '@/composables/useCreateNotify';
import {
  createEnterpriseService,
  createUserByEnterpriseService,
  deleteEnterpriseService,
  deleteUserByEnterpriseService,
  getEnterprisesService,
  getUsersByEnterpriseService,
  showEnterpriseService,
  showUserByEnterpriseService,
  updateEnterpriseService,
  updateUserByEnterpriseService,
} from '@/services/enterprise-service';

export const useEnterpriseStore = defineStore('enterprise', {
  state: () => ({
    loadingEnterprise: false as boolean,
    listEnterprises: [] as IEnterprise[],
    listUserDm: [] as IUserDm[],
  }),
  actions: {
    setLoading(loading: boolean) {
      this.loadingEnterprise = loading;
    },
    setListEnterprises(data: IEnterprise[] = []) {
      this.listEnterprises = data;
    },
    setListUserDm(data: IUserDm[] = []) {
      this.listUserDm = data;
    },
    async getEnterprises() {
      try {
        this.setLoading(true);
        const response = await getEnterprisesService();
        if (response.status === 200) {
          this.setListEnterprises(response.data.enterprises);
        }
        return response;
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async showEnterprise(enterpriseID: number) {
      try {
        this.setLoading(true);
        return await showEnterpriseService(enterpriseID);
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async createEnterprise(data: IDataEnterprise) {
      try {
        this.setLoading(true);
        const response = await createEnterpriseService(data);
        if (response.status === 201) {
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
    async updateEnterprise(data: IDataEnterprise) {
      try {
        this.setLoading(true);
        const response = await updateEnterpriseService(data);
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
    async deleteEnterprise(enterpriseID: number) {
      try {
        this.setLoading(true);
        const response = await deleteEnterpriseService(enterpriseID);
        if (response.status === 200) {
          this.setListEnterprises(response.data.enterprises);
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
    async showUserByEnterprise(enterpriseID: number, userID: number) {
      try {
        this.setLoading(true);
        return await showUserByEnterpriseService(enterpriseID, userID);
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async getUsersByEnterprise(enterpriseID: number) {
      try {
        this.setLoading(true);
        const response = await getUsersByEnterpriseService(enterpriseID);
        if (response.status === 200) {
          this.setListUserDm(response.data.users);
        }
        return response;
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async createUserByEnterprise(data: IDataUserDm, enterpriseID: number) {
      try {
        this.setLoading(true);
        const response = await createUserByEnterpriseService(
          data,
          enterpriseID
        );
        if (response.status === 201) {
          this.setListUserDm(response.data.users);
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
    async updateUserByEnterprise(
      data: IDataUserDm,
      userID: number,
      enterpriseID: number
    ) {
      try {
        this.setLoading(true);
        const response = await updateUserByEnterpriseService(
          data,
          enterpriseID,
          userID
        );
        if (response.status === 200) {
          this.setListUserDm(response.data.users);
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
    async deleteUserByEnterprise(userID: number, enterpriseID: number) {
      try {
        this.setLoading(true);
        const response = await deleteUserByEnterpriseService(
          userID,
          enterpriseID
        );
        if (response.status === 200) {
          this.setListUserDm(response.data.users);
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

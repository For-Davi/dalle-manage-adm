import { defineStore } from 'pinia';
import { createError, createSuccess } from '@/composables/useCreateNotify';
import {
  createSellerService,
  deleteRegistrationService,
  deleteSellerService,
  getSellersRegistrationService,
  getSellersService,
  showSellerRegistrationService,
  showSellerService,
  updateSellerService,
} from '@/services/seller-service';

export const useSellerStore = defineStore('seller', {
  state: () => ({
    loadingSeller: false as boolean,
    listRegistrations: [] as ISellerRegistration[],
    listSellers: [] as ISeller[],
  }),
  actions: {
    setLoading(loading: boolean) {
      this.loadingSeller = loading;
    },
    setListRegistrations(data: ISellerRegistration[] = []) {
      this.listRegistrations = data;
    },
    setListSellers(data: ISeller[] = []) {
      this.listSellers = data;
    },
    async getSellers() {
      try {
        this.setLoading(true);
        const response = await getSellersService();
        if (response.status === 200) {
          this.setListSellers(response.data.sellers);
        }
        return response;
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async showSeller(sellerID: number) {
      try {
        this.setLoading(true);
        return await showSellerService(sellerID);
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async showSellerRegistration(registrationID: number) {
      try {
        this.setLoading(true);
        return await showSellerRegistrationService(registrationID);
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async getSellersRegistration() {
      try {
        this.setLoading(true);
        const response = await getSellersRegistrationService();
        if (response.status === 200) {
          this.setListRegistrations(response.data.registrations);
        }
        return response;
      } catch (error) {
        createError(error);
        return null;
      } finally {
        this.setLoading(false);
      }
    },
    async createSeller(data: IDataSeller) {
      try {
        this.setLoading(true);
        const response = await createSellerService(data);
        if (response.status === 201) {
          this.setListSellers(response.data.sellers);
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
    async updateSeller(sellerID: number, data: IDataSeller) {
      try {
        this.setLoading(true);
        const response = await updateSellerService(sellerID, data);
        if (response.status === 200) {
          this.setListSellers(response.data.sellers);
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
    async deleteSeller(sellerID: number) {
      try {
        this.setLoading(true);
        const response = await deleteSellerService(sellerID);
        if (response.status === 200) {
          this.setListSellers(response.data.sellers);
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
    async deleteRegistration(registrationID: number) {
      try {
        this.setLoading(true);
        const response = await deleteRegistrationService(registrationID);
        if (response.status === 200) {
          this.setListRegistrations(response.data.registrations);
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

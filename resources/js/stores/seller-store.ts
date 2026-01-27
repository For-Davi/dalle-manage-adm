import { defineStore } from 'pinia';
import { createError, createSuccess } from '@/composables/CreateNotify';
import { createSellerService, deleteSellerService, getSellersRegistrationService, updateSellerService } from '@/services/seller-service';

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
    async updateSeller(data: IDataSeller) {
      try {
        this.setLoading(true);
        const response = await updateSellerService(data);
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
  },
});

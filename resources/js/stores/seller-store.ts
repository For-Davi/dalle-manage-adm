import { defineStore } from 'pinia';
import { createError } from '@/composables/CreateNotify';
import { getSellersRegistrationService } from '@/services/seller-service';

export const useSellerStore = defineStore('seller', {
  state: () => ({
    loadingSeller: false as boolean,
    listRegistrations: [] as ISellerRegistration[],
  }),
  actions: {
    setLoading(loading: boolean) {
      this.loadingSeller = loading;
    },
    setListRegistrations(data: ISellerRegistration[] = []) {
      this.listRegistrations = data;
    },
    async getSellersRegistration() {
      try {
        this.setLoading(true);
        const response = await getSellersRegistrationService();
        if (response.status === 200) {
          this.setListRegistrations(response.data.registrations);
        }
      } catch (error) {
        createError(error);
      } finally {
        this.setLoading(false);
      }
    },
  },
});

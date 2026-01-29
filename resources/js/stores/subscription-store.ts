import { defineStore } from 'pinia';
import { createError } from '@/composables/CreateNotify';
import { getSubscriptionsService } from '@/services/subscription-service';

export const useSubscriptionStore = defineStore('subscription', {
  state: () => ({
    loadingSubscription: false as boolean,
    listSubscriptions: [] as ISubscription[],
  }),
  actions: {
    setLoading(loading: boolean) {
      this.loadingSubscription = loading;
    },
    setListSubscriptions(data: ISubscription[] = []) {
      this.listSubscriptions = data;
    },
    async getSubscriptions() {
      try {
        this.setLoading(true);
        const response = await getSubscriptionsService();
        if (response.status === 200) {
          this.setListSubscriptions(response.data.subscriptions);
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

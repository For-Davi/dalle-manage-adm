import api from '@/lib/api';

const baseUrl = 'subscriptions';

// Empresas
export const getSubscriptionsService = (): Promise<{
  status: number;
  data: {
    message: string;
    subscriptions: ISubscription[];
  };
}> => {
  return api.get(`${baseUrl}/`);
};

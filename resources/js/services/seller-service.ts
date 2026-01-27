import api from '@/lib/api';

const baseUrl = 'seller';

export const getSellersRegistrationService = (): Promise<{
  status: number;
  data: {
    message: string;
    registrations: ISellerRegistration[];
  };
}> => {
  return api.get(`${baseUrl}/registrations`);
};

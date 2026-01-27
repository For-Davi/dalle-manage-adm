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

export const createSellerService = (
  data: IDataSeller
): Promise<{
  status: number;
  data: {
    message: string;
    sellers: ISeller[];
  };
}> => {
  return api.post(`${baseUrl}/`, data);
};

export const updateSellerService = (
  data: IDataSeller
): Promise<{
  status: number;
  data: {
    message: string;
    sellers: ISeller[];
  };
}> => {
  return api.put(`${baseUrl}/`, data);
};

export const deleteSellerService = (
  sellerID: number
): Promise<{
  status: number;
  data: {
    message: string;
    sellers: ISeller[];
  };
}> => {
  return api.delete(`${baseUrl}/${sellerID}`);
};

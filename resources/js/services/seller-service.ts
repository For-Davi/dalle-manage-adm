import api from '@/lib/api';

const baseUrl = 'sellers';

export const getSellersRegistrationService = (): Promise<{
  status: number;
  data: {
    message: string;
    registrations: ISellerRegistration[];
  };
}> => {
  return api.get(`${baseUrl}/registrations`);
};

export const getSellersService = (): Promise<{
  status: number;
  data: {
    message: string;
    sellers: ISeller[];
  };
}> => {
  return api.get(`${baseUrl}/`);
};

export const showSellerService = (
  sellerID: number
): Promise<{
  status: number;
  data: {
    message: string;
    seller: ISeller;
  };
}> => {
  return api.get(`${baseUrl}/${sellerID}`);
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
  sellerID: number,
  data: IDataSeller
): Promise<{
  status: number;
  data: {
    message: string;
    sellers: ISeller[];
  };
}> => {
  return api.put(`${baseUrl}/${sellerID}`, data);
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

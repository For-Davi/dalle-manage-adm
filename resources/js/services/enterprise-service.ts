import api from '@/lib/api';

const baseUrl = 'enterprises';

// Empresas
export const getEnterprisesService = (): Promise<{
  status: number;
  data: {
    message: string;
    enterprises: IEnterprise[];
  };
}> => {
  return api.get(`${baseUrl}/`);
};

export const createEnterpriseService = (
  data: IDataEnterprise
): Promise<{
  status: number;
  data: {
    message: string;
    enterprises: IEnterprise[];
  };
}> => {
  return api.post(`${baseUrl}/`, data);
};

export const updateEnterpriseService = (
  data: IDataEnterprise
): Promise<{
  status: number;
  data: {
    message: string;
    enterprises: IEnterprise[];
  };
}> => {
  return api.put(`${baseUrl}/`, data);
};

export const deleteEnterpriseService = (
  enterpriseID: number
): Promise<{
  status: number;
  data: {
    message: string;
    enterprises: IEnterprise[];
  };
}> => {
  return api.delete(`${baseUrl}/${enterpriseID}`);
};

// Usuários por empresa
export const getUsersByEnterpriseService = (
  enterpriseID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserDm[];
  };
}> => {
  return api.get(`${baseUrl}/users/${enterpriseID}/`);
};

export const createUserByEnterpriseService = (
  data: IDataUserDm,
  enterpriseID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserDm[];
  };
}> => {
  return api.post(`${baseUrl}/users/${enterpriseID}/`, data);
};

export const updateUserByEnterpriseService = (
  data: IDataUserDm,
  userID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserDm[];
  };
}> => {
  return api.put(`${baseUrl}/users/${userID}/`, data);
};

export const deleteUserByEnterpriseService = (
  userID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserDm[];
  };
}> => {
  return api.delete(`${baseUrl}/users/${userID}/`);
};

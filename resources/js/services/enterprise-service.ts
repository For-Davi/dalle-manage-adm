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

export const showEnterpriseService = (
  enterpriseID: number
): Promise<{
  status: number;
  data: {
    message: string;
    enterprise: IEnterprise;
  };
}> => {
  return api.get(`${baseUrl}/${enterpriseID}`);
};

export const createEnterpriseService = (
  data: IDataEnterprise
): Promise<{
  status: number;
  data: {
    message: string;
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
export const showUserByEnterpriseService = (
  enterpriseID: number,
  userID: number
): Promise<{
  status: number;
  data: {
    message: string;
    user: IUserDm;
  };
}> => {
  return api.get(`${baseUrl}/${enterpriseID}/users/${userID}`);
};

export const getUsersByEnterpriseService = (
  enterpriseID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserDm[];
  };
}> => {
  return api.get(`${baseUrl}/${enterpriseID}/users/`);
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
  return api.post(`${baseUrl}/${enterpriseID}/users/`, data);
};

export const updateUserByEnterpriseService = (
  data: IDataUserDm,
  enterpriseID: number,
  userID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserDm[];
  };
}> => {
  return api.put(`${baseUrl}/${enterpriseID}/users/${userID}/`, data);
};

export const deleteUserByEnterpriseService = (
    enterpriseID: number,
  userID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserDm[];
  };
}> => {
  return api.delete(`${baseUrl}/${enterpriseID}/users/${userID}/`);
};

import api from '@/lib/api';

const baseUrl = 'users';

export const updateProfileDataService = (
  data: IDataProfile
): Promise<{
  status: number;
  data: {
    message: string;
    user: IUserAdm;
  };
}> => {
  return api.put(`${baseUrl}/profile/data`, data);
};

export const updateProfilePasswordService = (
  data: IDataProfilePassword
): Promise<{
  status: number;
  data: {
    message: string;
  };
}> => {
  return api.put(`${baseUrl}/profile/password`, data);
};

export const getUsersService = (): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserAdm[];
  };
}> => {
  return api.get(`${baseUrl}/`);
};

export const createUserService = (
  data: IDataUserAdm
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserAdm[];
  };
}> => {
  return api.post(`${baseUrl}/`, data);
};

export const updateUserService = (
  data: IDataUserAdm
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserAdm[];
  };
}> => {
  return api.put(`${baseUrl}/`, data);
};

export const deleteUserService = (
  userID: number
): Promise<{
  status: number;
  data: {
    message: string;
    users: IUserAdm[];
  };
}> => {
  return api.delete(`${baseUrl}/${userID}`);
};

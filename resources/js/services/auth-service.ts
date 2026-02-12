import api from '@/lib/api';

export const loginService = (
  data: IDataLogin
): Promise<{
  status: number;
  data: {
    message: string;
    token: string;
    user: IUserAdm;
  };
}> => {
  return api.post('/login', data);
};

export const updateDataService = (
  data: IUpdateData
): Promise<{
  status: number;
  data: {
    message: string;
    user: IUserAdm;
  };
}> => {
  return api.put('users/profile/data', data);
};

export const updatePasswordService = (
  data: IUpdatePassword
): Promise<{
  status: number;
  data: {
    message: string;
  };
}> => {
  return api.put('users/profile/password', data);
};

export const logoutService = (): Promise<{
  status: number;
  data: {
    message: string;
  };
}> => {
  return api.post('/logout');
};

export const resetService = (
  email: string
): Promise<{
  status: number;
  data: {
    message: string;
  };
}> => {
  return api.post('/reset', email);
};

export const resetPasswordService = (
  data: IDataResetPassword
): Promise<{
  status: number;
  data: {
    message: string;
  };
}> => {
  return api.put('/reset-password', data);
};

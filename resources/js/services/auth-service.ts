import api from '@/lib/api';

export const loginService = (
  data: IDataLogin
): Promise<{
  status: number;
  data: {
    message: string;
  };
}> => {
  return api.post('/login', data);
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
  data: IDataReset
): Promise<{
  status: number;
  data: {
    message: string;
  };
}> => {
  return api.post('/reset', data);
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

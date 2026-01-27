/* eslint-disable @typescript-eslint/no-explicit-any */
import { AxiosError } from 'axios';
import { toast } from 'vue-sonner';

export const createError = (error: any) => {
  let message = 'Error';
  if (error instanceof AxiosError) {
    message = error.response?.data?.message;
  } else if (error instanceof Error) {
    message = error.message;
  }
  toast.error(message);
};

export const createSuccess = (message: string) => {
  toast.success(message);
};

export const createErrorData = (message: string) => {
  toast.error(message);
};

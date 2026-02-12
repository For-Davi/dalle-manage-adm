import { createErrorData } from '@/composables/useCreateNotify';

interface PasswordUpdate {
  currentPassword: string;
  password: string;
  confirmPassword: string;
}

interface DataUpdate {
  name: string;
  email: string;
}

export const validateUpdateData = (data: DataUpdate) => {
  const errors: string[] = [];

  if (!data.name) {
    errors.push('Deve ser informado o nome do vendedor');
  }

  if (
    data.email &&
    !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(data.email)
  ) {
    errors.push('Informe um e-mail válido');
  }

  if (errors.length) {
    createErrorData(errors.join('\n'));
    return { status: false };
  }

  return { status: true };
};

export const validateUpdatePassword = (data: PasswordUpdate) => {
  const errors: string[] = [];

  if (!data.currentPassword) {
    errors.push('Deve ser informada a senha atual');
  }
  if (!data.password || data.password.length < 8) {
    errors.push('Deve ser informada uma nova senha com no mínimo 8 caracteres');
  }

  if (data.password !== data.confirmPassword) {
    errors.push('As senhas não coincidem');
  }

  if (errors.length) {
    createErrorData(errors.join('\n'));
    return { status: false };
  }

  return { status: true };
};

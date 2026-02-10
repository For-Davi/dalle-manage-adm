import { createErrorData } from '@/composables/useCreateNotify';

interface DataCreate {
  name: string;
  email: string;
  password: string;
  confirmPassword: string;
}

export const validateCreate = (data: DataCreate) => {
  const errors: string[] = [];

  if (!data.name) {
    errors.push('Deve ser informado o nome do usuário');
  }

  if (
    data.email &&
    !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(data.email)
  ) {
    errors.push('Informe um e-mail válido');
  }

  if (data.password && data.password.length < 8) {
    errors.push('Informe uma senha com no mínimo 8 caracteres');
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

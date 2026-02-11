import { createErrorData } from '@/composables/useCreateNotify';
import { isValidPhone } from '@/composables/useValid';

interface DataCreate {
  name: string;
  email: string;
  phone: string;
  code: string;
}

interface DataUpdate {
  name: string;
  email: string;
  phone: string;
  code: string;
}

export const validateCreateOrUpdate = (data: DataCreate) => {
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

  if (data.code.length < 8 || data.code.length > 20) {
    errors.push(
      'Informe um código com no mínimo 8 caracteres e no máximo 20 caracteres'
    );
  }

  if (data.phone.length > 0 && !isValidPhone(data.phone)) {
    errors.push('Informe um telefone válido');
  }

  if (errors.length) {
    createErrorData(errors.join('\n'));
    return { status: false };
  }

  return { status: true };
};

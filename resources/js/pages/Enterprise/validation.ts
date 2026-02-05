import { createErrorData } from '@/composables/useCreateNotify';

interface DataCreate {
  name: string;
  email: string;
  phone: string;
  cpf: string;
  cnpj: string;
  cep: string;
  state: string;
  city: string;
  neighborhood: string;
  address: string;
  numberAddress: string;
  complement: string;
  subscriptionID: number | null;
  active: number;
}

export const validateCreateorUpdate = (data: DataCreate) => {
  const errors: string[] = [];

  if (!data.name) {
    errors.push('Deve ser informado o nome da empresa');
  }

  if (
    data.email &&
    !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(data.email)
  ) {
    errors.push('Informe um e-mail válido');
  }

  if (data.cpf && data.cpf.length !== 11) {
    errors.push('Informe um CPF válido');
  }

  if (data.cnpj && data.cnpj.length !== 14) {
    errors.push('Informe um CNPJ válido');
  }

  if (!data.subscriptionID) {
    errors.push('Informe uma assinatura');
  }

  if (errors.length) {
    createErrorData(errors.join('\n'));
    return { status: false };
  }

  return { status: true };
};

import { createErrorData } from '@/composables/useCreateNotify';
import { isValidPhone, isValidCPF } from '@/composables/useValid';

interface DataCreate {
  name: string;
  email: string;
  phone: string;
  cpf: string;
  password?: string;
  code: string;
  commission: number | string;
}

export const validateCreateOrUpdate = (data: DataCreate) => {
  const errors: string[] = [];

  if (data.name.trim() === '' || !data.name) {
    errors.push('Deve ser informado o nome do vendedor');
  }

  if (
    data.email &&
    !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(data.email)
  ) {
    errors.push('Informe um e-mail válido');
  }

  if (data.email.trim() === '') {
    errors.push('Deve ser informado o e-mail do(a) vendedor(a)');
  }

  if (data.code.length < 8 || data.code.length > 20) {
    errors.push(
      'Informe um código com no mínimo 8 caracteres e no máximo 20 caracteres'
    );
  }

  if (data.phone.length > 0 && !isValidPhone(data.phone)) {
    errors.push('Informe um telefone válido');
  }

  if (data.cpf.trim() === '') {
    errors.push('Deve ser informado o CPF do(a) vendedor(a)');
  }
  if (
    data.cpf.trim().length < 11 ||
    data.cpf.trim().length > 11 ||
    isNaN(Number(data.cpf.trim())) ||
    !isValidCPF(data.cpf)
  ) {
    errors.push('Informe um CPF válido');
  }
  if (data.password?.trim() === '') {
    errors.push('Deve ser informada a senha do(a) vendedor(a)');
  }
  if (data.password && data.password.trim().length < 8) {
    errors.push('A senha do(a) vendedor(a) deve ter 8 ou mais caracteres');
  }

  const commissionVal = Number(data.commission);

  if (
    data.commission === '' ||
    data.commission === null ||
    data.commission === undefined
  ) {
    errors.push('A comissão é obrigatória');
  } else if (isNaN(commissionVal)) {
    errors.push('A comissão deve ser um valor numérico');
  } else if (commissionVal < 0 || commissionVal > 100) {
    errors.push('Informe uma comissão entre 0 e 100');
  }

  if (errors.length) {
    createErrorData(errors.join('\n'));
    return { status: false };
  }

  return { status: true };
};

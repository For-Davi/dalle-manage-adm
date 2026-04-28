import { createErrorData } from '@/composables/useCreateNotify';

interface DataApproveRegistration {
  code: string;
  commission: string;
}

export const validateApproveRegistration = (data: DataApproveRegistration) => {
  const errors: string[] = [];

  if (data.commission.trim() == '') {
    errors.push('Informe a comissão do vendedor na faixa 0 - 100');
  }
  if (Number(data.commission) < 0 || Number(data.commission) > 100) {
    errors.push('A comissão deve estar na faixa de 0 - 100');
  }
  if (data.code.length < 8 || data.code.length > 20) {
    errors.push(
      'Informe um código com no mínimo 8 caracteres e no máximo 20 caracteres'
    );
  }

  if (errors.length) {
    createErrorData(errors.join('\n'));
    return { status: false };
  }

  return { status: true };
};

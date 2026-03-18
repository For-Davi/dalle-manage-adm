import { createErrorData } from '@/composables/useCreateNotify';

interface DataApproveRegistration {
  code: string;
}

export const validateApproveRegistration = (data: DataApproveRegistration) => {
  const errors: string[] = [];

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

export const getPaymentStatus = (status: string) => {
  switch (status) {
    case 'PENDING':
      return 'Pendente';
    case 'CONFIRMED':
      return 'Pago';
  }
};

export const getPaymentType = (type: string) => {
  switch (type) {
    case 'CREDIT_CARD':
      return 'Cartão de Crédito';
    case 'PIX':
      return 'Pix';
  }
};

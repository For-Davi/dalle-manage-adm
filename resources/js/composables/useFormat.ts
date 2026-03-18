export const formatPriceBR = (value: number): string => {
  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(value);
};

export const formatDateBrazil = (
  dataISO: string,
  subtractHours: number = 3
) => {
  if (!dataISO) return '';

  const data = new Date(dataISO);

  data.setHours(data.getHours() - subtractHours);

  return data
    .toLocaleString('pt-BR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      hour12: false,
    })
    .replace(',', '');
};

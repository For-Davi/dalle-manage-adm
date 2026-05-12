export const isValidPhone = (phone: string) => {
  if (!phone) return false;

  const cleaned = phone.replace(/\s|[-()]/g, '');

  return /^\+?\d{8,15}$/.test(cleaned);
};

export const isValidCPF = (cpf: string): boolean => {
  const cleaned = cpf.replace(/[^\d]/g, '');

  if (cleaned.length !== 11) return false;

  if (/^(\d)\1+$/.test(cleaned)) return false;

  let sum = 0;
  for (let i = 0; i < 9; i++) {
    sum += parseInt(cleaned[i]) * (10 - i);
  }
  let remainder = (sum * 10) % 11;
  if (remainder === 10 || remainder === 11) remainder = 0;
  if (remainder !== parseInt(cleaned[9])) return false;

  sum = 0;
  for (let i = 0; i < 10; i++) {
    sum += parseInt(cleaned[i]) * (11 - i);
  }
  remainder = (sum * 10) % 11;
  if (remainder === 10 || remainder === 11) remainder = 0;
  if (remainder !== parseInt(cleaned[10])) return false;

  return true;
};

export const isValidPhone = (phone: string) => {
  if (!phone) return false;

  const cleaned = phone.replace(/\s|[-()]/g, '');

  return /^\+?\d{8,15}$/.test(cleaned);
};

export const formatToBrazilianDate = (isoDate: string): string => {
  const date = new Date(isoDate);

  const day = String(date.getDate()).padStart(2, '0');
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const year = date.getFullYear();

  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');
  const seconds = String(date.getSeconds()).padStart(2, '0');

  return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
};

export const applyDateMask = (
  event: Event,
  field: string,
  data: Record<string, any>
) => {
  const input = event.target as HTMLInputElement;
  let value = input.value.replace(/\D/g, '');

  if (value.length > 2 && value.length <= 4) {
    value = `${value.slice(0, 2)}/${value.slice(2)}`;
  } else if (value.length > 4) {
    value = `${value.slice(0, 2)}/${value.slice(2, 4)}/${value.slice(4, 8)}`;
  }

  data[field] = value;
  input.value = value;
};

export function phoneValidation(value: string) {
  if (value.trim() !== '') {
    if (!/^(?:\+\d{1,3}\s?)?\(\d{2}\)\s?\d{4,5}-?\d{4}$/.test(value.trim())) {
      return 'Digite um telefone válido';
    }
  }
}

export const getNameSubscription = (value: string) => {
  switch (value) {
    case 'free':
      return 'Grátis';
    case 'basic':
      return 'Básico';
    default:
      return 'Premium';
  }
}
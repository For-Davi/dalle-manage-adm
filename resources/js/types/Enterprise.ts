export interface Enterprise {
  id: number;
  name: string;
  phone: string | null;
  cnpj: string | null;
  cpf: string | null;
  cep: string | null;
  state: string | null;
  city: string | null;
  email: string | null;
  neighborhood: string;
  address: string | null;
  complement: string | null;
  number_address: string | null;
  active: number;
  subscription_id: number;
  subscription: ISubscription;
}

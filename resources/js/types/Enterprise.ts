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
  seller_id: string | null;
  seller: ISeller | null;
  subscription_id: number;
  subscription: ISubscription;
}

export interface DataEnterprise {
  id?: number;
  name: string;
  phone: string | null;
  cnpj: string | null;
  cpf: string | null;
  cep: string | null;
  state: string | null;
  city: string | null;
  email: string | null;
  neighborhood: string | null;
  address: string | null;
  complement: string | null;
  numberAddress: string | null;
  active: number;
  sellerID: number | null;
  subscriptionID: number;
}

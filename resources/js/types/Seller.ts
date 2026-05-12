export interface Seller {
  id: number;
  name: string;
  email: string;
  phone: string;
  cpf: string;
  code: string;
  commission: number;
  created_at: string;
}

export interface SellerRegistration {
  id: number;
  name: string;
  email: string;
  phone: string;
  cpf: string;
  created_at: string;
  description: string | null;
}

export interface DataSeller {
  id?: number;
  name: string;
  email: string;
  phone: string;
  cpf: string;
  password: string;
  code: string;
  commission: number;
}

export interface Seller {
  id: number;
  name: string;
  email: string;
  phone: string;
  code: string;
  created_at: string;
}

export interface SellerRegistration {
  id: number;
  name: string;
  email: string;
  phone: string;
  created_at: string;
  description: string | null;
}

export interface DataSeller {
  id?: number;
  name: string;
  email: string;
  phone: string;
  code: string;
}

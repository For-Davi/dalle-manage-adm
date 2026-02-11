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
  registration_date: string;
  description: string | null;
}

export interface DataSeller {
  id?: number;
  name: string;
  email: string;
  phone: string;
  code: string;
}

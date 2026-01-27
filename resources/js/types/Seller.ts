export interface Seller {
  id: number;
  name: string;
  email: string;
  phone: string;
  code: string;
}

export interface SellerRegistration {
  id: number;
  name: string;
  email: string;
  phone: string;
  registration_date: string;
  description: string | null;
}

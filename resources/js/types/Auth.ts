export type RenderAuth = 'auth' | 'reset';

export interface DataLogin {
  email: string;
  password: string;
}

export interface DataResetPassword {
  token: string;
  password: string;
}

export type RenderAuth = 'auth' | 'reset';

export interface DataLogin {
  email: string;
  password: string;
}

export interface DataReset {
  email: string;
}

export interface DataResetPassword {
  token: string;
  password: string;
}

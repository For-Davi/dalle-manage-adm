import type { User } from './User.ts';
import type { RenderAuth } from './Auth.ts';
import type { Enterprises } from './Enterprises.ts';
export {};

declare global {
  type IUser = User;

  type IRenderAuth = RenderAuth;

  type IEnterprises = Enterprises;
}

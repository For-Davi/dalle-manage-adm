import type { User } from './User.ts';
import type { RenderAuth } from './Auth.ts';
import type { Enterprises } from './Enterprises.ts';
import type { Subscriptions } from './Subscriptions.ts';
export {};

declare global {
  type IUser = User;

  type IRenderAuth = RenderAuth;

  type IEnterprises = Enterprises;

  type ISubscriptions = Subscriptions;
}

import type { User } from './User.ts';
import type { RenderAuth } from './Auth.ts';
import type { Enterprise } from './Enterprise.ts';
import type { Subscription } from './Subscription.ts';
export {};

declare global {
  type IUser = User;

  type IRenderAuth = RenderAuth;

  type IEnterprise = Enterprise;

  type ISubscription = Subscription;
}

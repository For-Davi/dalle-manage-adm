import type { User } from './User.ts';
import type { RenderAuth } from './Auth.ts';
import type { Enterprise } from './Enterprise.ts';
import type { Subscription } from './Subscription.ts';
import { Users } from './Users.ts';
export {};

declare global {
  type IUser = User;

  type IRenderAuth = RenderAuth;

  type IEnterprise = Enterprise;

  type ISubscription = Subscription;

  type IUsers = Users;
}

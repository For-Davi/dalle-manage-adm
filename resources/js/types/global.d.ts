import type { User } from './User.ts';
import type {
  RenderAuth,
  DataLogin,
  DataReset,
  DataResetPassword,
} from './Auth.ts';
import type { Enterprise } from './Enterprise.ts';
import type { Subscription } from './Subscription.ts';
import { Seller, SellerRegistration } from './Seller.ts';

export {};

declare global {
  type IUser = User;

  type IRenderAuth = RenderAuth;

  type IEnterprise = Enterprise;

  type ISubscription = Subscription;

  type ISeller = Seller;

  type ISellerRegistration = SellerRegistration;

  type IDataLogin = DataLogin;

  type IDataReset = DataReset;

  type IDataResetPassword = DataResetPassword;
}

import type {
  DataProfile,
  DataProfilePassword,
  DataUserAdm,
  DataUserDm,
  UserAdm,
  UserDm,
} from './User.ts';
import type {
  RenderAuth,
  DataLogin,
  DataReset,
  DataResetPassword,
} from './Auth.ts';
import type { DataEnterprise, Enterprise } from './Enterprise.ts';
import type { Subscription } from './Subscription.ts';
import { DataSeller, Seller, SellerRegistration } from './Seller.ts';
import { Department } from './Department.js';
import { Image } from './Media.js';

export {};

declare global {
  type IUserAdm = UserAdm;

  type IRenderAuth = RenderAuth;

  type IEnterprise = Enterprise;

  type ISubscription = Subscription;

  type ISeller = Seller;

  type ISellerRegistration = SellerRegistration;

  type IDataLogin = DataLogin;

  type IDataReset = DataReset;

  type IDataResetPassword = DataResetPassword;

  type IDataSeller = DataSeller;

  type IDataProfile = DataProfile;

  type IDataProfilePassword = DataProfilePassword;

  type IDataUserAdm = DataUserAdm;

  type IDataEnterprise = DataEnterprise;

  type IDepartment = Department;

  type IImage = Image;

  type IUserDm = UserDm;

  type IDataUserDm = DataUserDm;
}

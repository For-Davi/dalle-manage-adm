import type { User } from './User.ts';
export {};

declare global {
  type IUser = User;
}

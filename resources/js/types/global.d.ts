import type { User } from './User.ts';
import type { RenderAuth } from './Auth.ts';
export {};

declare global {
  type IUser = User;

  type IRenderAuth = RenderAuth;
}

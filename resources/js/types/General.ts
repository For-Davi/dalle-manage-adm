import { RouteLocationRaw } from 'vue-router';

export type MenuAction = {
  label?: string;
  icon?: any;
  variant?: string;
  class?: string;
  disabled?: boolean;
  type?: 'button' | 'submit' | 'reset';
  loading?: boolean;
  onClick?: () => void;
};

export interface BreadcrumbItem {
  label: string;
  to?: RouteLocationRaw;
}

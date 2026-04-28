import type { RouteRecordRaw } from 'vue-router';
import { userRoutes } from './user.routes';

export const enterpriseRoutes: RouteRecordRaw[] = [
  {
    path: 'enterprises',
    name: 'enterprises',
    component: () => import('@/pages/Enterprise/EnterpriseIndex.vue'),
  },
  {
    path: 'enterprises/create',
    name: 'enterprise.create',
    component: () => import('@/pages/Enterprise/EnterpriseCreate.vue'),
  },
  {
    path: 'enterprises/:id/edit',
    name: 'enterprise.edit',
    component: () => import('@/pages/Enterprise/EnterpriseEdit.vue'),
    props: true,
  },
  {
    path: 'enterprises/payments',
    name: 'enterprise.payments',
    component: () => import('@/pages/Enterprise/EnterprisePayments.vue'),
    props: true,
  },
  ...userRoutes,
];

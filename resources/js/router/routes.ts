import type { RouteRecordRaw } from 'vue-router';
import { enterpriseRoutes } from './modules/enterprise/enterprise.routes';
import { userRoutes } from './modules/user.routes';
import { sellerRoutes } from './modules/seller.routes';
import { subscriptionRoutes } from './modules/subscription.routes';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'auth',
    component: () => import('@/pages/Auth.vue'),
  },
  {
    path: '/reset-password/:token(.*)',
    name: 'resetPassword',
    component: () => import('@/pages/ResetPassword.vue'),
    props: true,
  },
  {
    path: '/adm',
    component: () => import('@/layouts/MainLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: { name: 'dashboard' },
      },
      {
        path: 'dashboard',
        name: 'dashboard',
        component: () => import('@/pages/Dashboard.vue'),
      },
      ...enterpriseRoutes,
      ...userRoutes,
      ...sellerRoutes,
      ...subscriptionRoutes,
    ],
  },

  {
    path: '/:catchAll(.*)*',
    component: () => import('@/pages/ErrorNotFound.vue'),
  },
];

export default routes;

import type { RouteRecordRaw } from 'vue-router';

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
      {
        path: 'enterprises',
        name: 'enterprises',
        component: () => import('@/pages/Enterprise.vue'),
      },
      {
        path: 'users',
        name: 'users',
        component: () => import('@/pages/User.vue'),
      },
      {
        path: 'subscriptions',
        name: 'subscriptions',
        component: () => import('@/pages/Subscription.vue'),
      },
      {
        path: 'sellers',
        name: 'sellers',
        component: () => import('@/pages/Seller.vue'),
      },
      {
        path: 'sellers/registrations',
        name: 'sellerRegistrations',
        component: () => import('@/pages/SellerRegistration.vue'),
      },
    ],
  },

  {
    path: '/:catchAll(.*)*',
    component: () => import('@/pages/ErrorNotFound.vue'),
  },
];

export default routes;

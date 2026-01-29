import type { RouteRecordRaw } from 'vue-router';
import { registrationRoutes } from './registration.routes';

export const sellerRoutes: RouteRecordRaw[] = [
  {
    path: 'sellers',
    name: 'sellers',
    component: () => import('@/pages/Seller/SellerIndex.vue'),
  },
  {
    path: 'sellers/create',
    name: 'seller.create',
    component: () => import('@/pages/Seller/SellerCreate.vue'),
  },
  {
    path: 'sellers/:id/edit',
    name: 'seller.edit',
    component: () => import('@/pages/Seller/SellerEdit.vue'),
    props: true,
  },
  ...registrationRoutes,
];

import type { RouteRecordRaw } from 'vue-router';

export const userRoutes: RouteRecordRaw[] = [
  {
    path: 'users',
    name: 'users',
    component: () => import('@/pages/User/UserIndex.vue'),
  },
  {
    path: 'users/create',
    name: 'user.create',
    component: () => import('@/pages/User/UserCreate.vue'),
  },
  {
    path: 'users/:id/edit',
    name: 'user.edit',
    component: () => import('@/pages/User/UserEdit.vue'),
    props: true,
  },
];
